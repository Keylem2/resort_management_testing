<?php

namespace App\Http\Controllers\StaffHead;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class StaffHeadLeaveRequestController extends Controller
{
    public function index()
{
    // Fetch all pending leave requests for the Staff Head to review
    $leaveRequests = LeaveRequest::whereHas('employee', function ($query) {
        $query->whereIn('usertype', ['life_guard', 'house_keeper']); // Only Lifeguards and Housekeepers
    })
    ->where('status', 'pending')
    ->get();

    return view('staff_head.leave.index', compact('leaveRequests'));
}

    public function show($leaveRequestId)
    {
        // Show details of a specific leave request
        $leaveRequest = LeaveRequest::findOrFail($leaveRequestId);
        return view('staff_head.leave.show', compact('leaveRequest'));
    }

    public function approve($leaveRequestId)
    {
        // Approve the leave request
        $leaveRequest = LeaveRequest::findOrFail($leaveRequestId);
        $leaveRequest->update(['status' => 'approved']);
        return redirect()->route('staff_head.leave.index')->with('success', 'Leave request approved successfully.');
    }

    public function reject($leaveRequestId)
    {
        // Reject the leave request
        $leaveRequest = LeaveRequest::findOrFail($leaveRequestId);
        $leaveRequest->update(['status' => 'rejected']);
        return redirect()->route('staff_head.leave.index')->with('success', 'Leave request rejected successfully.');
    }

    public function store(Request $request)
{
    // Validate input
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'leave_type' => 'required|string',
        'reason' => 'nullable|string',
    ]);

    // Get the authenticated user
    $user = auth()->user();

    // Check if the user is 'lifeguard' or 'housekeeper'
    if ($user->usertype === 'life_guard' || $user->usertype === 'house_keeper') {
        // Create leave request for the user
        LeaveRequest::create([
            'employee_id' => $user->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
            'status' => 'pending', // Default status is pending
        ]);

        return redirect()->route('leave.requests.index')->with('success', 'Leave request submitted successfully!');
    }

    return redirect()->route('home')->with('error', 'You are not authorized to submit a leave request.');
}

}
