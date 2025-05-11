<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create or retrieve the admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@bluebelleresort.com'],
            [
                'name' => 'Admin User',
                'usertype' => 'admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create or retrieve the guest user
        $guest = User::firstOrCreate(
            ['email' => 'guest@example.com'],
            [
                'name' => 'Test Guest',
                'usertype' => 'user',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );


    }
}
