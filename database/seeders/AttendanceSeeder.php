<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Faker\Factory as Faker;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get all employees
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Seed attendance for the last 30 days
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::now()->subDays($i);
                
                // Random check-in and check-out times
                $checkIn = $faker->time('H:i:s', '09:30:00');
                $checkOut = $faker->time('H:i:s', '18:00:00');
                $isLate = $checkIn > '09:00:00';

                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date->toDateString(),
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'late' => $isLate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                echo "Attendance for Employee ID: {$employee->id} on {$date->toDateString()} added.\n";
            }
        }
    }
}
