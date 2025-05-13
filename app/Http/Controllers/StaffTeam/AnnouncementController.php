<?php

namespace App\Http\Controllers\StaffTeam;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        
        // Mark announcements as read
        Announcement::where('department', $employee->department)
            ->orWhere('position', $employee->position)
            ->whereDoesntHave('reads', function($query) {
                $query->where('employee_id', Auth::user()->employee->id);
            })
            ->each(function($announcement) {
                $announcement->reads()->create([
                    'employee_id' => Auth::user()->employee->id
                ]);
            });
        
        return view('staff_team.announcements.index', [
            'announcements' => Announcement::where('department', $employee->department)
                                    ->orWhere('position', $employee->position)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10)
        ]);
    }
}