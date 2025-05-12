<?php

namespace App\Http\Controllers\StaffTeam;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StaffTeamController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        return view('staff_team.dashboard', [
            'todaysTasks' => $employee->tasks()->today()->count(),
            'tasksCompletedPercent' => $employee->tasks()->today()->completed()->count() / max(1, $employee->tasks()->today()->count()) * 100,
            'currentShift' => $employee->currentShift(),
            'pendingInventoryRequests' => $employee->inventoryRequests()->pending()->count(),
            'approvedInventoryRequests' => $employee->inventoryRequests()->approved()->count(),
            'recentAnnouncements' => \App\Models\Announcement::forPosition($employee->position)->recent()->get()
        ]);
    }
}