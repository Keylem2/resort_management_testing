<?php
namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    /**
     * Store a new leave request for Lifeguard/Housekeeper.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'leave_type' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        // Get the authenticated user (Lifeguard or Housekeeper)
        $user = auth()->user();

        // Check if the user is 'lifeguard' or 'housekeeper'
        if ($user->usertype === 'lifeguard' || $user->usertype === 'house_keeper') {
            // Create a leave request for the user
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

    /**
     * Display the leave requests for the logged-in user (Lifeguard/Housekeeper).
     */
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Fetch the leave requests for the user
        $leaveRequests = LeaveRequest::where('employee_id', $user->id)->get();

        // Return the view with the leave requests
        return view('leave_requests.index', compact('leaveRequests'));
    }
}
