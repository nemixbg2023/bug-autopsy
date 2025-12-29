<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BugEntry;

class BugReport extends Model
{
    protected $fillable = [
        'title',
        'symptoms',
        'severity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function entries()
    {
        return $this->hasMany(BugEntry::class);
    }

    /**
    * @throws \InvalidArgumentException
    * @throws \DomainException
    */
    public function addEntry(string $type, string $content, ?string $evidence = null): BugEntry
    {
        $allowed = BugEntry::TYPES;

        if (!in_array($type, $allowed, true)) {
            throw new \InvalidArgumentException("Invalid entry type: {$type}");
        }

        if ($type === BugEntry::TYPE_CONCLUSION && $this->entries()->where('type', 'conclusion')->exists()) {
            throw new \DomainException('This bug report already has a conclusion.');
        }

        return $this->entries()->create([
            'type' => $type,
            'content' => $content,
            'evidence' => $evidence,
        ]);


    }

}
