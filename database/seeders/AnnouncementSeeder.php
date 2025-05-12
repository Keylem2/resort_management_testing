<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        Announcement::create([
            'title' => 'Monthly Team Meeting',
            'content' => 'There will be a monthly team meeting this Friday. Please be on time.',
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2),
        ]);

        Announcement::create([
            'title' => 'Safety Training',
            'content' => 'All lifeguards are required to attend the safety training on the beach.',
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5),
        ]);
    }
}
