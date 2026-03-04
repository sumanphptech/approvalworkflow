<?php

namespace App\Jobs;

use App\Models\ApprovalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ApprovalApprovedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ApprovalRequest $approvalRequest;
    public string $action; 

    /**
     * Create a new job instance.
     */
    public function __construct(ApprovalRequest $approvalRequest, string $action)
    {
        $this->approvalRequest = $approvalRequest;
        $this->action = $action;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Log the action
        Log::info("Request #{$this->approvalRequest->id} was {$this->action} by user #{$this->approvalRequest->approved_by}");
    }
}
