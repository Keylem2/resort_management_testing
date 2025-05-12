<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EmployeeSeeder::class,
            UserSeeder::class,
            LeaveRequestSeeder::class,
            PayrollSeeder::class,
            EventSeeder::class,
            AttendanceSeeder::class,
            HRActivitySeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
