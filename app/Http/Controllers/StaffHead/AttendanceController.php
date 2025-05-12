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
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'late' => $request->has('late'),
        ]);

        return redirect()->route('staff_head.attendance.index')->with('success', 'Attendance marked successfully.');
    }

    public function markAttendance(Request $request)
{
    // Validate the input
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'date' => 'required|date',
        'check_in' => 'nullable|date_format:H:i',
        'check_out' => 'nullable|date_format:H:i',
        'late' => 'nullable|boolean',
    ]);

    // Logic to store attendance in the database
    $attendance = Attendance::create([
        'employee_id' => $request->employee_id,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'late' => $request->late ?? false,
    ]);

    // Redirect back to the attendance page with success message
    return redirect()->route('staff_head.attendance.index')->with('success', 'Attendance marked successfully!');
}

    public function showMarkAttendanceForm()
{
    $employees = Employee::where('department', 'HR') // or relevant department
                  ->whereIn('position', ['Housekeeper', 'Lifeguard'])
                  ->get();
                  
    return view('staff_head.attendance.mark', compact('employees'));
}

     public function attendanceIndex()
    {
        // Get all team members under the Staff Head
        $teamMembers = Employee::whereIn('position', ['Housekeeper', 'Lifeguard'])->get();

        // Pass the data to the view
        return view('staff_head.attendance.index', compact('teamMembers'));
    }
    
    public function attendanceStore(Request $request)
    {
    // Your logic for storing attendance goes here
    }

    


}
