<?php

/**
 *
 * Domain rules for BugReport and BugEntry.
 *
 * These tests ensure that core business invariants
 * cannot be violated by application code.
 *
 */

namespace Tests\Feature;

use App\Models\User;
use App\Enums\BugEntryType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class BugEntryRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_bug_report_cannot_have_two_conclusions(): void
    {
        $user = User::factory()->create();

        $bug = $user->bugReports()->create([
            'title' => 'Login doesn\'t work',
            'symptoms' => 'HTTP 500 error after submit',
            'severity' => 'high',
        ]);

        $bug->addEntry(BugEntryType::Conclusion, 'First conclusion.');

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('This bug report already has a conclusion.');

        $bug->addEntry(BugEntryType::Conclusion, 'Second concludion.');

    }

    public function test_bug_report_is_resolved_only_after_conclusion(): void
    {
        $user = User::factory()->create();

        $bug = $user->bugReports()->create([
            'title' => 'Checkout fails',
            'symptoms' => 'HTTP 500 error during checkout',
            'severity' => 'medium',
        ]);

        $this->assertFalse($bug->isResolved());

        $bug->addEntry(BugEntryType::Conclusion, 'Fix: add a null check in the payment handler.');

        $bug->refresh();

        $this->assertTrue($bug->isResolved());

        // PHPUnit may mark this test as "risky" in some setups; this makes intent explicit.
        $this->addToAssertionCount(1);
    }
}
