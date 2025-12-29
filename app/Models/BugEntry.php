<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BugReport;

class BugEntry extends Model
{
    public const TYPE_HYPOTHESIS = 'hypothesis';
    public const TYPE_EXPERIMENT = 'experiment';
    public const TYPE_FINDING = 'finding';
    public const TYPE_CONCLUSION ='conslusion';

    public const TYPES = [
        self::TYPE_HYPOTHESIS,
        self::TYPE_EXPERIMENT,
        self::TYPE_FINDING,
        self::TYPE_CONCLUSION,
    ];

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
