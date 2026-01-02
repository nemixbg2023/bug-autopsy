<?php

namespace App\Enums;

enum BugEntryType: string
{
    case Hypothesis = 'hypothesis';
    case Experiment = 'experiment';
    case Finding = 'finding';
    case Conclusion = 'conclusion';

    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
