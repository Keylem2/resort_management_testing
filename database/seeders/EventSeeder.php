<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Employee;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $employees = Employee::all();

        for ($i = 0; $i < 20; $i++) {
            Event::create([
                'title' => $faker->randomElement(['Team Building', 'Monthly Meeting', 'Holiday Party', 'Training Session', 'Employee Birthday']),
                'date' => $faker->dateTimeBetween('-1 month', '+3 months'),
                'time' => $faker->time('H:i:s'),
                'type' => $faker->randomElement(['holiday', 'birthday', 'training', 'meeting']),
                'employee_id' => $employees->random()->id,
            ]);
        }
    }
}
