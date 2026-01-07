<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugEntryController;
use App\Http\Controllers\BugReportController;

Route::post('/bug-reports/{bugReport}/entries', [BugEntryController::class, 'store'])
    ->name('bug-reports.entries.store');

Route::get('/bug-reports/{bugReport}', [BugReportController::class, 'show']);
