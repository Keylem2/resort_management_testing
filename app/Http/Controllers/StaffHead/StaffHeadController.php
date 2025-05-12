<?php

namespace App\Http\Controllers\StaffHead;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StaffHeadController extends Controller
{
    public function dashboard()
    {
        // Get the staff members under this staff head (Housekeepers and Lifeguards)
        $teamMembers = Employee::whereIn('position', ['Housekeeper', 'Lifeguard'])->get();

        // Get today's date for attendance tracking
        $today = now()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        // Total team members
        $totalTeamMembers = $teamMembers->count();

        // Present today
        $presentToday = $teamMembers->filter(function ($member) use ($today) {
            return $member->attendances()->whereDate('date', $today)->exists();
        })->count();

        // Present yesterday
        $presentYesterday = $teamMembers->filter(function ($member) use ($yesterday) {
            return $member->attendances()->whereDate('date', $yesterday)->exists();
        })->count();

        // Calculate attendance change
        if ($presentYesterday > 0) {
            $attendanceChange = (($presentToday - $presentYesterday) / $presentYesterday) * 100;
        } else {
            $attendanceChange = $presentToday > 0 ? 100 : 0;
        }

        // On leave today
        $onLeaveToday = LeaveRequest::where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->whereHas('employee', function ($query) {
                $query->whereIn('position', ['Housekeeper', 'Lifeguard']);
            })
            ->count();

        // Pending leave requests
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')
            ->whereHas('employee', function ($query) {
                $query->whereIn('position', ['Housekeeper', 'Lifeguard']);
            })
            ->count();

        // Announcements
        $totalAnnouncements = Announcement::count();
        $recentAnnouncements = Announcement::whereDate('created_at', '>=', Carbon::now()->subWeek())->count();

        // Sample data for team change percentage
        $teamChange = rand(-5, 10);  // Replace with actual logic if needed

        // Fetch recent activities (last 7 days)
        $recentActivities = Attendance::whereDate('created_at', '>=', Carbon::now()->subWeek())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('staff_head.dashboard', compact(
            'teamMembers', 
            'totalTeamMembers', 
            'presentToday', 
            'onLeaveToday', 
            'pendingLeaveRequests', 
            'teamChange',
            'attendanceChange',
            'totalAnnouncements',
            'recentAnnouncements',
            'recentActivities'
        ));
    }

    public function teamIndex()
    {
        // Fetch all team members under this staff head (Housekeepers and Lifeguards)
        $teamMembers = Employee::whereIn('position', ['Housekeeper', 'Lifeguard'])->get();

        return view('staff_head.team.index', compact('teamMembers'));
    }
    
}