<?php

namespace App\Http\Controllers\StaffTeam\Position;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LifeguardController extends Controller
{
    public function schedule()
    {
        $employee = Auth::user()->employee;
        
        return view('staff_team.position.lifeguard.schedule', [
            'currentShift' => $employee->currentShift(),
            'weeklySchedule' => $employee->shifts()
                                ->whereBetween('date', [
                                    now()->startOfWeek(),
                                    now()->endOfWeek()
                                ])
                                ->orderBy('date')
                                ->get(),
            'poolStatus' => \App\Models\Pool::first()
        ]);
    }
}