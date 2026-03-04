<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ApprovalRequest;
use App\Jobs\ApprovalApprovedJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;

class ApprovalRequestTest extends TestCase
{
    use RefreshDatabase;

    protected User $approver;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles if you have a roles table
        $approverRole = \App\Models\Role::create(['name' => 'APPROVER']);
        $userRole = \App\Models\Role::create(['name' => 'USER']);

        // Create users
        $this->approver = User::factory()->create(['role_id' => $approverRole->id]);
        $this->user = User::factory()->create(['role_id' => $userRole->id]);
    }

    public function test_non_approver_cannot_approve_or_reject()
    {
        $request = ApprovalRequest::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        // Acting as a normal user
        $this->actingAs($this->user)
            ->post("/requests/{$request->id}/approve")
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->post("/requests/{$request->id}/reject")
            ->assertStatus(403);
    }

    public function test_approver_dispatches_job_on_approve_and_reject()
    {
        Queue::fake(); // Fake the queue to test dispatching

        $request = ApprovalRequest::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        // Approve
        $this->actingAs($this->approver)
            ->post("/requests/{$request->id}/approve")
            ->assertStatus(302); // redirect back

        Queue::assertPushed(ApprovalApprovedJob::class, function ($job) use ($request) {
            return $job->approvalRequest->id === $request->id
                && $job->action === 'approved';
        });

        // Reject
        $request2 = ApprovalRequest::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        $this->actingAs($this->approver)
            ->post("/requests/{$request2->id}/reject")
            ->assertStatus(302);

        Queue::assertPushed(ApprovalApprovedJob::class, function ($job) use ($request2) {
            return $job->approvalRequest->id === $request2->id
                && $job->action === 'rejected';
        });
    }

}
