<?php

namespace App\Models;

use App\Enums\BugEntryType;
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
    public function addEntry(BugEntryType $type, string $content, ?string $evidence = null): BugEntry
    {
        if ($type === BugEntryType::Conclusion && $this->hasConclusion()) {
            throw new \DomainException('This bug report already has a conclusion.');
        }

        return $this->entries()->create([
            'type' => $type->value,
            'content' => $content,
            'evidence' => $evidence,
        ]);


    }

    public function hasConclusion(): bool
    {
        return $this->entries()
            ->where('type', BugEntryType::Conclusion->value)
            ->exists();
    }

    public function isResolved(): bool
    {
        return $this->hasConclusion();
    }

}
