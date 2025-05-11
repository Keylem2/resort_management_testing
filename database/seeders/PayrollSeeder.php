<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payroll;
use App\Models\Employee;
use Faker\Factory as Faker;

class PayrollSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $employees = Employee::all();

        foreach ($employees as $employee) {
            for ($i = 0; $i < 3; $i++) {
                $grossSalary = $employee->salary;
                $deductions = $faker->numberBetween(500, 5000);
                $netSalary = $grossSalary - $deductions;
                $processed = $faker->boolean(70); // 70% chance of being processed

                Payroll::create([
                    'employee_id' => $employee->id,
                    'payroll_date' => $faker->dateTimeBetween('-3 months', 'now'),
                    'gross_salary' => $grossSalary,
                    'deductions' => $deductions,
                    'net_salary' => $netSalary,
                    'processed' => $processed,
                ]);
            }
        }
    }
}
