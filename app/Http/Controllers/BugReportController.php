<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use Illuminate\Http\Request;

class BugReportController extends Controller
{
    public function show(BugReport $bugReport)
    {
        $bugReport->load('entries');

        return response()->json([
            'id' => $bugReport->id,
            'title' => $bugReport->title,
            'symptoms' => $bugReport->symptoms,
            'severity' => $bugReport->severity,
            'resolved' => $bugReport->isResolved(),
            'entries' =>$bugReport->entries->map(fn ($entry) => [
                'id' => $entry->id,
                'type' => $entry->type->value,
                'content' => $entry->content,
                'evidence' => $entry->evidence,
                'created_at' => $entry->created_at?->toISOString(),
            ])->values(),
        ]);

    }
}
