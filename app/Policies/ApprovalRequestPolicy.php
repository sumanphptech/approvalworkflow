<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ApprovalRequest;
use App\Models\User;

class ApprovalRequestPolicy
{
    /**
     * Determine whether the user can approve the request.
     */
    public function approve(User $user, ApprovalRequest $request): bool
    {
        // Only users with role 'approver' can approve
        return $user->role->name === 'APPROVER';
    }

    /**
     * Determine whether the user can reject the request.
     */
    public function reject(User $user, ApprovalRequest $request): bool
    {
        // Only users with role 'approver' can reject
        return $user->role->name === 'APPROVER';
    }
}
