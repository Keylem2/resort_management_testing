<?php

namespace App\Http\Controllers\StaffHead;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Team;
use App\Models\LeaveRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class StaffHeadDashboardController extends Controller
{
    public function index()
    {
        $teamMembers = Employee::whereIn('position', ['Housekeeper', 'Lifeguard'])->get();
        $totalTeamMembers = $teamMembers->count();
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();
        $announcements = Announcement::latest()->take(5)->get();
        
        return view('staffhead.dashboard', [
            'totalTeamMembers' => $totalTeamMembers,
            'pendingLeaveRequests' => $pendingLeaveRequests,
            'announcements' => $announcements,
        ]);
    }
}

class TeamController extends Controller
{
    public function index()
    {
        $teams = ['Housekeepers', 'Lifeguards'];
        $members = Employee::whereIn('position', ['Housekeeper', 'Lifeguard'])->get();
        return view('staffhead.teams.index', compact('teams', 'members'));
    }

    public function show($team)
    {
        $members = Employee::where('position', $team)->get();
        return view('staffhead.teams.show', compact('members', 'team'));
    }

    public function store(Request $request)
    {
        Employee::create($request->all());
        return Redirect::route('staffhead.teams.index')->with('success', 'Member added successfully.');
    }
}

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::whereHas('employee', function($query) {
            $query->whereIn('position', ['Housekeeper', 'Lifeguard']);
        })->get();

        return view('staffhead.attendance.index', compact('attendances'));
    }

    public function approve($attendanceId)
    {
        $attendance = Attendance::findOrFail($attendanceId);
        $attendance->status = 'approved';
        $attendance->save();
        return Redirect::back()->with('success', 'Attendance approved successfully.');
    }

    public function reject($attendanceId)
    {
        $attendance = Attendance::findOrFail($attendanceId);
        $attendance->status = 'rejected';
        $attendance->save();
        return Redirect::back()->with('success', 'Attendance rejected successfully.');
    }
}

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::whereHas('employee', function($query) {
            $query->whereIn('position', ['Housekeeper', 'Lifeguard']);
        })->get();
        return view('staffhead.leave.index', compact('leaveRequests'));
    }

    public function approve($leaveId)
    {
        $leave = LeaveRequest::findOrFail($leaveId);
        $leave->status = 'approved';
        $leave->save();
        return Redirect::back()->with('success', 'Leave request approved successfully.');
    }

    public function reject($leaveId)
    {
        $leave = LeaveRequest::findOrFail($leaveId);
        $leave->status = 'rejected';
        $leave->save();
        return Redirect::back()->with('success', 'Leave request rejected successfully.');
    }
}

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('staffhead.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        Announcement::create($request->all());
        return Redirect::route('staffhead.announcements.index')->with('success', 'Announcement created successfully.');
    }

    public function destroy($announcementId)
    {
        Announcement::findOrFail($announcementId)->delete();
        return Redirect::back()->with('success', 'Announcement deleted successfully.');
    }
}
