<!doctype html>
<html>
<head>
<meta charset="utf-8">

<style>
@page {
    size: A4 landscape;
    margin: 10px;
}

body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 9px;
}


table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

thead {
    display: table-header-group;
}


th, td {
    border: 1px solid #999;
    text-align: center;
    vertical-align: middle;  
    padding: 5px 2px;         
    line-height: 1.3;         
}


th {
    background: #f1f5f9;
    font-size: 8px;
}


th.roll, td.roll {
    width: 35px;
    font-size: 9px;
}

th.student, td.student {
    width: 150px;           
    text-align: left;
    font-weight: bold;
    padding-left: 6px;
    white-space: normal;
    word-break: break-word;
}
th.ta, td.ta { width: 45px; }
th.percent, td.percent { width: 40px; }


th.date {
    width: 18px;
    padding: 0;
    vertical-align: bottom;
}

th.date > div {
    transform: rotate(-90deg);
    transform-origin: bottom left;
    white-space: nowrap;
    width: 18px;
    font-size: 7px;
    margin-bottom: 4px;       
}


td.att {
    font-weight: bold;
    font-size: 9px;
}


th.ta, td.ta,
th.percent, td.percent {
    width: 45px;
    font-weight: bold;
}


tbody tr {
    height: 24px;         
}

tr { page-break-inside: avoid; }


.header {
    text-align: center;
    margin-bottom: 6px;
}


.footer {
    position: fixed;
    bottom: -8px;
    right: 0;
    font-size: 9px;
}
.pagenum:before {
    content: counter(page);
}
</style>
</head>

<body>

<div class="header">
    <h4>Attendance Report</h4>
    <div>Period: {{ $period }}</div>
</div>

<table>
<thead>
<tr>
    <th class="roll">Roll</th>
    <th class="student">Student</th>

    @foreach($dates as $d)
        <th class="date">
            <div>{{ \Carbon\Carbon::parse($d)->format('d M') }}</div>
        </th>
    @endforeach

    <th class="ta">TA</th>
    <th class="percent">%</th>
</tr>
</thead>

<tbody>
@foreach($matrix as $row)
<tr>
    <td class="roll">{{ $row['student']->id }}</td>
    <td class="student">{{ $row['student']->name }}</td>

    @foreach($dates as $d)
        <td>{{ $row['statuses'][$d] ?? '' }}</td>
    @endforeach

    <td class="ta">{{ $row['present'] }}/{{ $row['total'] }}</td>
    <td class="percent">{{ number_format($row['percent'],1) }}</td>
</tr>
@endforeach
</tbody>
</table>

<div class="footer">
    Page <span class="pagenum"></span>
</div>

</body>
</html>
