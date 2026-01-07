<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\BugReport;
use App\Enums\BugEntryType;

class BugEntry extends Model
{
    protected $fillable = [
        'type',
        'content',
        'evidence',
    ];

    protected $casts = [
        'type' => BugEntryType::class,
    ];

    const UPDATED_AT = null;

    public function bugReport(): BelongsTo
    {
        return $this->belongsTo(BugReport::class);
    }
}
