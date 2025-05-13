<?php

namespace App\Http\Controllers\StaffTeam\Position;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HousekeeperController extends Controller
{
    public function schedule()
    {
        $employee = Auth::user()->employee;
        
        return view('staff_team.position.housekeeper.schedule', [
            'currentAssignment' => $employee->currentAssignment(),
            'cleaningSchedule' => $employee->cleaningAssignments()
                                    ->whereBetween('date', [
                                        now()->startOfWeek(),
                                        now()->endOfWeek()
                                    ])
                                    ->orderBy('date')
                                    ->get(),
            'cleaningSupplies' => \App\Models\CleaningSupply::assignedTo($employee->id)
                                    ->get()
        ]);
    }
}