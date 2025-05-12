<?php

namespace App\Http\Controllers\StaffHead;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
     public function index()
    {
        // Get the team members (Housekeepers and Lifeguards)
        $teamMembers = Employee::whereIn('position', ['Housekeeper', 'Lifeguard'])->get();

        // Pass the team members to the view
        return view('staff_head.attendance.index', compact('teamMembers'));
    }

    public function mark(Request $request)
    {
        // Mark attendance for a specific team member
        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => now()->format('Y-m-d'),
            'check_in' => now()->format('H:i:s'),
            'late' => $request->has('late'),
        ]);

        return redirect()->route('staff_head.attendance.index')->with('success', 'Attendance marked successfully.');
    }

    public function markAttendance(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $today = Carbon::today();

        // Check if attendance already exists
        $existing = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();

        if (!$existing) {
            Attendance::create([
                'employee_id' => $employeeId,
                'date' => $today,
                'check_in' => now(),
            ]);
        }

        return redirect()->route('staff_head.attendance.index')->with('success', 'Attendance marked successfully.');
    }

     public function attendanceIndex()
    {
        // Get all team members under the Staff Head
        $teamMembers = Employee::whereIn('position', ['Housekeeper', 'Lifeguard'])->get();

        // Pass the data to the view
        return view('staff_head.attendance.index', compact('teamMembers'));
    }
    
}
