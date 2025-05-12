<?php

namespace App\Http\Controllers\StaffHead;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        // Show leave requests from team members
        $leaveRequests = LeaveRequest::whereHas('employee', function ($query) {
            $query->whereIn('position', ['Housekeeper', 'Lifeguard']);
        })->orderBy('created_at', 'desc')->get();

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
}
