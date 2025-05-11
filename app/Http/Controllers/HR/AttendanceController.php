<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('hr');
    }

    public function index()
    {
        // Fetch all attendance records
        $attendances = Attendance::orderBy('date', 'desc')->paginate(10);

        return view('hr.attendance.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('hr.attendance.create', compact('employees'));
    }

    public function store(Request $request)
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

    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('hr.attendance.show', compact('attendance'));
    }
}
