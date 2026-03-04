<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApprovalRequest;
use App\Jobs\ApprovalApprovedJob;
use Illuminate\Support\Facades\Auth;

class ApprovalRequestController extends Controller
{
    // Submit a new request
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        ApprovalRequest::create([
            'title' => $request->title,
            'user_id' => Auth::id(), 
        ]);

        return back()->with('success', 'Request submitted successfully!');
    }

    // Approve a request
    public function approve(ApprovalRequest $approvalRequest)
    {
        $this->authorize('approve', $approvalRequest);

        $approvalRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Dispatch async job
        ApprovalApprovedJob::dispatch($approvalRequest, 'approved');
        
        return back()->with('success', 'Request approved!');
    }

    // Reject a request
    public function reject(ApprovalRequest $approvalRequest)
    {
        $this->authorize('reject', $approvalRequest);

        $approvalRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Dispatch async job
        ApprovalApprovedJob::dispatch($approvalRequest, 'rejected');

        return back()->with('success', 'Request rejected!');
    }

}
