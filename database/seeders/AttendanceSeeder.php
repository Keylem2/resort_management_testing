<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Employee;
use Faker\Factory as Faker;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $employees = Employee::all();

        foreach ($employees as $employee) {
            for ($i = 0; $i < 20; $i++) {
                $checkIn = $faker->dateTimeBetween('-1 month', 'now');
                $checkOut = (clone $checkIn)->modify('+8 hours');
                $late = $faker->boolean(30); // 30% chance of being late

                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $checkIn->format('Y-m-d'),
                    'check_in' => $checkIn->format('H:i:s'),
                    'check_out' => $checkOut->format('H:i:s'),
                    'late' => $late,
                ]);
            }
        }
    }
}
