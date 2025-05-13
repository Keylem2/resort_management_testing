<?php

namespace App\Http\Controllers\StaffTeam;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StaffTeamController extends Controller
{
    public function dashboard()
{
    $user = Auth::user();
    
    // Get the employee through the user relationship
    $employee = $user->employee;
    
    if (!$employee) {
        abort(403, 'No employee record found for this user');
    }

    return view('staff_team.dashboard', [
        'todaysTasks' => $employee->tasks()->whereDate('due_date', today())->count(),
        'tasksCompletedPercent' => $this->calculateTasksCompletion($employee),
        'currentShift' => $this->getCurrentShift($employee),
        'pendingInventoryRequests' => $employee->inventoryRequests()->where('status', 'pending')->count(),
        'approvedInventoryRequests' => $employee->inventoryRequests()->where('status', 'approved')->count(),
        'recentAnnouncements' => $this->getRecentAnnouncements($employee)
    ]);
}

protected function getRecentAnnouncements($employee)
{
    return \App\Models\Announcement::query()
        ->where('department', $employee->department)
        ->orWhere('position', $employee->position)
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get()
        ->map(function ($announcement) use ($employee) {
            $announcement->is_new = !$announcement->reads()->where('employee_id', $employee->id)->exists();
            return $announcement;
        });
}

    protected function calculateTasksCompletion($employee)
    {
        $total = $employee->tasks()->whereDate('due_date', today())->count();
        $completed = $employee->tasks()->whereDate('due_date', today())->where('status', 'completed')->count();
        
        return $total > 0 ? round(($completed / $total) * 100) : 0;
    }

    protected function getCurrentShift($employee)
    {
        // Implement your shift logic here
        return [
            'name' => 'Morning Shift',
            'time' => '8:00 AM - 4:00 PM'
        ];
    }


}