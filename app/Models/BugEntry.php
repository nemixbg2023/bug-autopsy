<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BugReport;

class BugEntry extends Model
{
    protected $fillable = [
        'type',
        'content',
        'evidence',
    ];

    const UPDATED_AT = null;

    public function bugReport()
    {
        return $this->belongsTo(BugEntry::class);
    }
}
