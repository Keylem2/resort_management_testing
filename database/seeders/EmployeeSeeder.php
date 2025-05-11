<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // Define employees with corresponding user IDs
        $employees = [
            [
                'id' => 76,
                'employee_code' => 'FIN-001',
                'name' => 'Finance Staff',
                'email' => 'finance@gmail.com',
                'position' => 'Finance Staff',
                'department' => 'Finance',
                'hire_date' => '2022-01-01',
                'phone' => '09171234567',
                'salary' => 23000,
                'status' => 'active',
                'user_id' => 14,
            ],
            [
                'id' => 60,
                'employee_code' => 'HR-001',
                'name' => 'HR Manager',
                'email' => 'hr@example.com',
                'position' => 'HR Manager',
                'department' => 'Human Resources',
                'hire_date' => '2021-01-01',
                'phone' => '09172345678',
                'salary' => 27000,
                'status' => 'active',
                'user_id' => 17,
            ],
            [
                'id' => 52,
                'employee_code' => 'FD-001',
                'name' => 'Front Desk Staff',
                'email' => 'frontdesk@resort.com',
                'position' => 'Front Desk Staff',
                'department' => 'Front Desk',
                'hire_date' => '2023-01-01',
                'phone' => '09173456789',
                'salary' => 15000,
                'status' => 'active',
                'user_id' => 13,
            ],
        ];

        // Create or update employees
        foreach ($employees as $data) {
            $employee = Employee::updateOrCreate(
                ['id' => $data['id']],
                [
                    'employee_code' => $data['employee_code'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'position' => $data['position'],
                    'department' => $data['department'],
                    'hire_date' => $data['hire_date'],
                    'phone' => $data['phone'],
                    'salary' => $data['salary'],
                    'status' => $data['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Link the user to the employee
            User::where('id', $data['user_id'])->update([
                'employee_id' => $employee->id,
            ]);

            echo "Employee ID: {$employee->id} - {$employee->name} linked to User ID: {$data['user_id']}\n";
        }
    }
}
