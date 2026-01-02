<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\BugEntryType;

class BugEntryRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_bug_report_cannot_have_two_conclusions(): void
    {
        $user = \App\Models\User::factory()->create();

        $bug = $user->bugReports()->create([
            'title' => 'Login ne radi',
            'symptoms' => '500 nakon submit-a',
            'severity' => 'high',
        ]);

        $bug->addEntry(BugEntryType::Conclusion, 'Prvi zaključak.');

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('This bug report already has a conclusion.');

        $bug->addEntry(BugEntryType::Conclusion, 'Drugi zaključak.');

    }
}
