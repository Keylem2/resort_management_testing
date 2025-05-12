<?php

namespace App\Http\Controllers\StaffHead;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        // List all team members under this staff head
        $teamMembers = Employee::whereIn('position', ['Housekeeper', 'Lifeguard'])->get();
        return view('staff_head.team.index', compact('teamMembers'));
    }

    public function show($employeeId)
    {
        // Show details for a specific team member
        $employee = Employee::findOrFail($employeeId);
        return view('staff_head.team.show', compact('employee'));
    }
}
