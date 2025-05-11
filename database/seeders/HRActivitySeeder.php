<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HRActivity;
use App\Models\Employee;
use Faker\Factory as Faker;

class HRActivitySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $employees = Employee::all();

        foreach ($employees as $employee) {
            for ($i = 0; $i < 10; $i++) {
                HRActivity::create([
                    'employee_id' => $employee->id,
                    'type' => $faker->randomElement(['attendance', 'leave', 'payroll', 'employee']),
                    'title' => $faker->sentence(6),
                    'description' => $faker->paragraph(2),
                    'action_url' => $faker->url,
                ]);
            }
        }
    }
}
