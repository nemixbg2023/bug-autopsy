<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use App\Enums\BugEntryType;
use Illuminate\Http\Request;

class BugEntryController extends Controller
{
    public function store(Request $request, BugReport $bugReport)
    {
        $data = $request->validate([
            'type' => ['required', 'string'],
            'content' => ['required', 'string', 'min:3'],
            'evidence' => ['nullable', 'string'],
        ]);

        try {
            $type = BugEntryType::from($data['type']);
        } catch (\ValueError $e) {
            return response()->json([
                'message' => 'Invalid bug entry type.'
            ], 422);
        }

        try {
            $entry = $bugReport->addEntry(
                $type,
                $data['content'],
                $data['evidence'] ?? null
            );
        } catch (\DomainException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }

        return response()->json([
            'id' => $entry->id,
            'type' => $entry->type,
            'content' => $entry->content,
            'evidence' => $entry->evidence,
        ], 201);

    }
}
