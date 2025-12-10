<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;


Route::get('/', [ReportController::class, 'form'])->name('report.form');
Route::post('/report/generate', [ReportController::class, 'generate'])->name('report.generate');