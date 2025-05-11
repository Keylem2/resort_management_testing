<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define users with matching employee IDs
        $users = [
            [
                'name' => 'Front Desk Staff',
                'email' => 'frontdesk@resort.com',
                'password' => Hash::make('password'),
                'usertype' => 'front_desk',
                'employee_id' => 52, // Match with employee ID
                'email_verified_at' => Carbon::now(),
                'remember_token' => \Str::random(10),
            ],
            [
                'name' => 'Finance Staff',
                'email' => 'finance@gmail.com',
                'password' => Hash::make('password'),
                'usertype' => 'finance',
                'employee_id' => 76, // Match with employee ID
                'email_verified_at' => Carbon::now(),
                'remember_token' => \Str::random(10),
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'usertype' => 'admin',
                'employee_id' => null, // No matching employee
                'email_verified_at' => Carbon::now(),
                'remember_token' => \Str::random(10),
            ],
            [
                'name' => 'User Account',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'usertype' => 'user',
                'employee_id' => null, // No matching employee
                'email_verified_at' => Carbon::now(),
                'remember_token' => \Str::random(10),
            ],
            [
                'name' => 'HR Manager',
                'email' => 'hr@example.com',
                'password' => bcrypt('password'),
                'usertype' => 'hr',
                'employee_id' => 60, // Match with employee ID
                'email_verified_at' => now(),
                'remember_token' => \Str::random(10),
            ],
        ];

        // Create users
        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
