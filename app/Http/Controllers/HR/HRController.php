<?php

namespace App\Http\Controllers\HR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\HRActivity;
use App\Models\Event;
use Carbon\Carbon;

class HRController extends Controller
{
    public function __construct()
    {
        $this->middleware('hr');
    }

    public function dashboard()
{
    // Total Employees
    $totalEmployees = Employee::count();

    // Employee Change
    $previousMonthEmployees = Employee::where('created_at', '<', Carbon::now()->subMonth())->count();
    $employeeChange = $totalEmployees - $previousMonthEmployees;

    // On Leave Today
    $today = Carbon::today();
    $onLeaveToday = LeaveRequest::where('status', 'approved')
        ->whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->count();

    // Pending Leave Requests
    $leaveRequestsPending = LeaveRequest::where('status', 'pending')->count();

    // Late Arrivals
    $lateArrivalsToday = Attendance::whereDate('date', $today)
        ->whereTime('check_in', '>', '09:00:00')
        ->count();

    // Payroll Status (dummy for now)
    $payrollProcessed = false;
    $payrollProcessDate = now()->subDays(5);
    $payrollDueDays = 10;

    // Recent HR Activities
    $recentActivities = HRActivity::latest()->take(5)->get();

    // Upcoming Events
    $upcomingEvents = Event::where('date', '>=', now())
        ->orderBy('date', 'asc')
        ->take(6)
        ->get();

    return view('hr.dashboard', [
        'totalEmployees' => $totalEmployees,
        'employeeChange' => $employeeChange,
        'onLeaveToday' => $onLeaveToday,
        'leaveRequestsPending' => $leaveRequestsPending,
        'lateArrivalsToday' => $lateArrivalsToday,
        'lateArrivalChange' => 0,
        'payrollProcessed' => $payrollProcessed,
        'payrollProcessDate' => $payrollProcessDate,
        'payrollDueDays' => $payrollDueDays,
        'recentActivities' => $recentActivities,
        'upcomingEvents' => $upcomingEvents, // <-- Make sure this is included
    ]);
}

    public function createAttendance()
    {
        $employees = Employee::all();
        return view('hr.attendance.create', compact('employees'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,absent,late'
        ]);

        Attendance::create($request->all());

        return redirect()->route('hr.attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    public function runPayroll()
{
    // Logic for running payroll, you can later add more detailed logic
    $employees = Employee::all();
    return view('hr.payroll.run', compact('employees'));
}

public function processPayroll(Request $request)
{
    // Example logic for processing payroll
    foreach ($request->employee_ids as $employeeId) {
        Payroll::create([
            'employee_id' => $employeeId,
            'amount' => 50000, // Replace with actual salary calculation
            'status' => 'processed',
            'processed_at' => now(),
        ]);
    }

    return redirect()->route('hr.payroll.index')->with('success', 'Payroll processed successfully.');
}

    public function salary()
{
    // Fetch all employees
    $employees = Employee::paginate(10);

    // Return the salary view with the employees data
    return view('hr.payroll.salary', compact('employees'));
}

    public function payslip($employeeId)
{
    $employee = Employee::findOrFail($employeeId);
    return view('hr.payroll.payslip', compact('employee'));
}


    public function createLeave()
{
    $employees = Employee::all();
    return view('hr.leave.create', compact('employees'));
}

public function events()
{
    $events = Event::orderBy('date', 'asc')->get();
    return view('hr.events.index', compact('events'));
}

public function createEvent()
{
    return view('hr.events.create');
}

public function storeEvent(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'date' => 'required|date',
        'time' => 'nullable|string|max:20',
        'type' => 'required|string|max:20',
        'employee_id' => 'nullable|exists:employees,id',
    ]);

    Event::create($request->all());

    return redirect()->route('hr.events.index')->with('success', 'Event created successfully.');
}

public function editEvent($id)
{
    $event = Event::findOrFail($id);
    return view('hr.events.edit', compact('event'));
}

public function updateEvent(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'date' => 'required|date',
        'time' => 'nullable|string|max:20',
        'type' => 'required|string|max:20',
        'employee_id' => 'nullable|exists:employees,id',
    ]);

    $event = Event::findOrFail($id);
    $event->update($request->all());

    return redirect()->route('hr.events.index')->with('success', 'Event updated successfully.');
}

public function destroyEvent($id)
{
    $event = Event::findOrFail($id);
    $event->delete();

    return redirect()->route('hr.events.index')->with('success', 'Event deleted successfully.');
}

}
