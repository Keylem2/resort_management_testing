<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HRActivity;
use App\Models\Employee;
use Carbon\Carbon;

class HRActivitySeeder extends Seeder
{
    public function run()
    {
        // Fetch existing employees
        $employees = Employee::all();

        // Sample activities
        $activities = [
            [
                'type' => 'employee',
                'title' => 'New Employee Onboarded',
                'description' => 'Front Desk Staff joined the company.',
                'action_url' => '/hr/employees/52',
                'employee_id' => 52,
            ],
            [
                'type' => 'leave',
                'title' => 'Leave Approved',
                'description' => 'HR Manager approved a leave request.',
                'action_url' => '/hr/leave',
                'employee_id' => 60,
            ],
            [
                'type' => 'payroll',
                'title' => 'Payroll Processed',
                'description' => 'Finance Staff processed payroll for the month.',
                'action_url' => '/hr/payroll',
                'employee_id' => 76,
            ],
            [
                'type' => 'attendance',
                'title' => 'Attendance Recorded',
                'description' => 'Attendance for all employees marked for today.',
                'action_url' => '/hr/attendance',
                'employee_id' => 60,
            ],
            [
                'type' => 'general',
                'title' => 'Company Meeting Scheduled',
                'description' => 'A company-wide meeting has been scheduled.',
                'action_url' => '/hr/events',
                'employee_id' => 60,
            ],
        ];

        // Seed the activities
        foreach ($activities as $data) {
            HRActivity::create(array_merge($data, [
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now(),
            ]));
        }

        echo "HR activities seeded successfully.\n";
    }
}
