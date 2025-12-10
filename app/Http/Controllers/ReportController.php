<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF; // barryvdh/laravel-dompdf facade


class ReportController extends Controller
{
        public function form()
        {
            return view('report_form');
        }


        public function generate(Request $request)
        {
        
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);


        $start = Carbon::parse($request->input('start_date'))->startOfDay();


        if ($request->filled('end_date')) {
        $end = Carbon::parse($request->input('end_date'))->endOfDay();
        } else {
        $end = (clone $start)->addDays(10)->endOfDay();
        }





        $dates = DB::table('attendance_dates')
            ->whereBetween(DB::raw('DATE(datetime)'), [
                $start->toDateString(),
                $end->toDateString()
            ])
            ->orderBy('datetime')
            ->pluck(DB::raw('DATE(datetime)'))
            ->unique()
            ->values()
            ->toArray();



        if (empty($dates)) {
            $dates = DB::table('attendances')
            ->select(DB::raw('DATE(created_at) as date'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$start->toDateString(), $end->toDateString()])
            ->groupBy('date')
            ->orderBy('date','asc')
            ->pluck('date')
            ->map(function($d){ return (string)$d; })
            ->toArray();
        }



        $students = DB::table('students')
            ->select('id', 'name', 'user_id')
            ->orderBy('id')
            ->get();


        $attendanceMatrix = [];


        $raw = DB::table('attendances')
            ->join(
                'attendance_dates',
                'attendance_dates.id',
                '=',
                'attendances.attendance_date_id'
            )
            ->select(
                'attendances.attendee_id',
                DB::raw('DATE(attendance_dates.datetime) as date'),
                'attendances.status'
            )
            ->whereBetween(
                DB::raw('DATE(attendance_dates.datetime)'),
                [$start->toDateString(), $end->toDateString()]
            )
            ->get()
            ->groupBy('attendee_id');



        foreach ($students as $s) {
            $row = ['student' => $s, 'statuses' => []];
            $presentCount = 0;

            foreach ($dates as $d) {
                $status = '';

                if ($s->user_id && isset($raw[$s->user_id])) {
                    foreach ($raw[$s->user_id] as $att) {
                        if ($att->date === $d) {
                            $status = $att->status;
                            if (strtoupper($status) === 'P') {
                                $presentCount++;
                            }
                            break;
                        }
                    }
                }

                $row['statuses'][$d] = $status;
            }

            $total = count($dates);
            $row['present'] = $presentCount;
            $row['total'] = $total;
            $row['percent'] = $total ? round(($presentCount / $total) * 100, 1) : 0;

            $attendanceMatrix[] = $row;
        }



        $data = [
            'dates' => $dates,
            'matrix' => $attendanceMatrix,
            'period' => $start->toDateString() . ' - ' . $end->toDateString(),
            'start' => $start,
            'end' => $end,
        ];


        $pdf = PDF::loadView('report_pdf', $data)
        ->setPaper('a4', 'landscape');


        $filename = 'attendance_report_'.now()->format('Ymd_His').'.pdf';


        return $pdf->stream($filename);
        }
}