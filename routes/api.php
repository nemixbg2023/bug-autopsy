<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugEntryController;

Route::post('/bug-reports/{bugReport}/entries', [BugEntryController::class, 'store'])
    ->name('bug-reports.entries.store');

Route::get('/ping', fn () => ['ok' => true]);
