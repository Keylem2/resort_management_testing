<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
        User::create([
            'name' => 'Front Desk Staff',
            'email' => 'frontdesk@resort.com',
            'password' => Hash::make('password'),
            'usertype' => 'front_desk',
            'email_verified_at' => Carbon::now(), // Marking the email as verified
            'remember_token' => \Str::random(10),
        ]);

        User::create([
            'name' => 'Finance Staff',
            'email' => 'finance@gmail.com',
            'password' => Hash::make('password'),
            'usertype' => 'finance',
            'email_verified_at' => Carbon::now(), // Marking the email as verified
            'remember_token' => \Str::random(10),
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'usertype' => 'admin',
            'email_verified_at' => Carbon::now(), // Marking the email as verified
            'remember_token' => \Str::random(10),
        ]);

        User::create([
            'name' => 'User Account',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'usertype' => 'user',
            'email_verified_at' => Carbon::now(), // Marking the email as verified
            'remember_token' => \Str::random(10),
        ]);
        
    }
}
