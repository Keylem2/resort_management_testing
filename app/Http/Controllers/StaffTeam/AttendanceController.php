<?php

namespace App\Http\Controllers\StaffTeam;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        
        return view('staff_team.attendance.index', [
            'today' => Attendance::where('employee_id', $employee->id)
                            ->whereDate('date', today())
                            ->first(),
            'recent' => Attendance::where('employee_id', $employee->id)
                            ->orderBy('date', 'desc')
                            ->take(10)
                            ->get(),
            'monthSummary' => [
                'present' => Attendance::where('employee_id', $employee->id)
                                ->whereMonth('date', now()->month)
                                ->whereNotNull('check_in')
                                ->count(),
                'late' => Attendance::where('employee_id', $employee->id)
                                ->whereMonth('date', now()->month)
                                ->where('late', true)
                                ->count()
            ]
        ]);
    }

    public function checkIn(Request $request)
    {
        $employee = Auth::user()->employee;
        
        $attendance = Attendance::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'date' => today()
            ],
            [
                'check_in' => now()->format('H:i:s'),
                'late' => $this->isLateCheckIn()
            ]
        );

        return redirect()->route('staff_team.attendance.index')
            ->with('success', 'Checked in successfully at ' . $attendance->check_in);
    }

    public function checkOut(Request $request)
    {
        $employee = Auth::user()->employee;
        
        $attendance = Attendance::where('employee_id', $employee->id)
                        ->whereDate('date', today())
                        ->firstOrFail();
                        
        $attendance->update([
            'check_out' => now()->format('H:i:s')
        ]);

        return redirect()->route('staff_team.attendance.index')
            ->with('success', 'Checked out successfully at ' . $attendance->check_out);
    }

    protected function isLateCheckIn()
    {
        $expectedTime = config('attendance.expected_check_in');
        return now()->format('H:i') > $expectedTime;
    }
}