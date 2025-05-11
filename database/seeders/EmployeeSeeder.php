<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) {
            Employee::create([
                'employee_code' => 'EMP-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'department' => $faker->randomElement(['HR', 'Finance', 'Sales', 'Engineering']),
                'position' => $faker->jobTitle,
                'hire_date' => $faker->date,
                'salary' => $faker->numberBetween(30000, 120000),
                'status' => 'active',
            ]);
        }
    }
}
