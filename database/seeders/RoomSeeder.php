<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $rooms = [
            // Couple Rooms (7)
            [
                'room_type' => 'Couple Room',
                'room_number' => '101',
                'price_per_night' => 2500,
                'capacity' => 2,
                'description' => 'Cozy room perfect for couples with basic amenities',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'room_type' => 'Couple Room',
                'room_number' => '102',
                'price_per_night' => 2500,
                'capacity' => 2,
                'description' => 'Cozy room perfect for couples with basic amenities',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Add 5 more couple rooms (103-107)
            
            // Family Rooms (2)
            [
                'room_type' => 'Family Room',
                'room_number' => '201',
                'price_per_night' => 5500,
                'capacity' => 8,
                'description' => 'Spacious room for families with multiple beds and extra amenities',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'room_type' => 'Family Room',
                'room_number' => '202',
                'price_per_night' => 5500,
                'capacity' => 8,
                'description' => 'Spacious room for families with multiple beds and extra amenities',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Add 5 more couple rooms
        for ($i = 3; $i <= 7; $i++) {
            $rooms[] = [
                'room_type' => 'Couple Room',
                'room_number' => '10' . $i,
                'price_per_night' => 2500,
                'capacity' => 2,
                'description' => 'Cozy room perfect for couples with basic amenities',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('rooms')->insert($rooms);
    }
}