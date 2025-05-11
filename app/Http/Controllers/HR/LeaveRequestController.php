<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    public function create()
    {
        $employees = Employee::all();
        return view('HR.leave.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date|after_or_equal:' . now()->toDateString(),
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:5',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        LeaveRequest::create($request->all());

        return redirect()->route('hr.leave.index')->with('success', 'Leave request created successfully.');
    }
}
