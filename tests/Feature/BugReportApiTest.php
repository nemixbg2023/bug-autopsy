<?php

namespace Tests\Feature;

use App\Models\User;
use App\Enums\BugEntryType;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BugReportApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_entry_via_api_and_prevent_second_conclusion(): void
    {
        $user = User::factory()->create();

        $bug = $user->bugReports()->create([
            'title' => 'API bug',
            'symptoms' => 'Testing API rules',
            'severity' => 'high',
        ]);

        $response = $this->postJson("/api/bug-reports/{$bug->id}/entries", [
            'type' => BugEntryType::Conclusion->value,
            'content' => 'First conclusion',
        ]);

        $response->assertCreated();

        $response = $this->postJson("/api/bug-reports/{$bug->id}/entries", [
            'type' => BugEntryType::Conclusion->value,
            'content' => 'Second conclusion',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'This bug report already has a conclusion.',
        ]);
    }

    public function test_can_fetch_bug_report_with_resolved_state_and_entries(): void
    {
        $user = User::factory()->create();

        $bug = $user->bugReports()->create([
            'title' => 'GET bug',
            'symptoms' => 'Testing GET endpoint',
            'severity' =>'low',
        ]);

        // Before conclusion: bug must not be resoled
        $response = $this->getJson("/api/bug-reports/{$bug->id}")
                        ->assertOk()
                        ->assertJson([
                            'id' => $bug->id,
                            'resolved' => false,
                        ]);

        // Setup: add conclusion directly throught the domain
        $bug->addEntry(BugEntryType::Conclusion, "Root couse fixed.");
        $bug->refresh();

        // After conclusion: bug must be resolved and entry type must be "conclusion"
        $response = $this->getJson("/api/bug-reports/{$bug->id}")
                        ->assertOk()
                        ->assertJson([
                            'id' => $bug->id,
                            'resolved' => true,
                        ])
                        ->assertJsonPath('entries.0.type', BugEntryType::Conclusion->value);

    }

}
