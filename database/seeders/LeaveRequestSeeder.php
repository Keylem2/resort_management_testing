<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveRequest;
use App\Models\Employee;
use Faker\Factory as Faker;

class LeaveRequestSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $employees = Employee::all();

        foreach ($employees as $employee) {
            for ($i = 0; $i < 5; $i++) {
                $startDate = $faker->dateTimeBetween('-1 month', '+1 month');
                $endDate = (clone $startDate)->modify('+' . $faker->numberBetween(1, 5) . ' days');

                LeaveRequest::create([
                    'employee_id' => $employee->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'leave_type' => $faker->randomElement(['Sick Leave', 'Vacation Leave', 'Maternity Leave', 'Paternity Leave', 'Personal Leave']),
                    'reason' => $faker->sentence(10),
                    'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                ]);
            }
        }
    }
}
