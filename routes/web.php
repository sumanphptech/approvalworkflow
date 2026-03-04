<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApprovalRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    // Submit a new request
    Route::post('/requests', [ApprovalRequestController::class, 'store']);

    // List approvals 
    Route::get('/requests', [ApprovalRequestController::class, 'index'])->name('requests.index');

    // Create new approval request
    Route::get('/requests/create', [ApprovalRequestController::class, 'create'])->name('requests.create');

    // Approve a request
    Route::post('/requests/{approvalRequest}/approve', [ApprovalRequestController::class, 'approve']);

    // Reject a request
    Route::post('/requests/{approvalRequest}/reject', [ApprovalRequestController::class, 'reject']);   
});

require __DIR__.'/auth.php';