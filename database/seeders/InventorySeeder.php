<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    public function run()
    {
        $amenities = [
            // Bedding (non-consumable)
            [
                'name' => 'Mattress',
                'description' => 'Standard queen-size mattress',
                'price' => null,
                'is_consumable' => false,
                'stock_quantity' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Pillow',
                'description' => 'Standard hotel pillow',
                'price' => null,
                'is_consumable' => false,
                'stock_quantity' => 50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Towel',
                'description' => 'Bath towel set',
                'price' => 200.00,
                'is_consumable' => false,
                'stock_quantity' => 40,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Toiletries (consumable)
            [
                'name' => 'Soap',
                'description' => 'Bar soap',
                'price' => 25.00,
                'is_consumable' => true,
                'stock_quantity' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Shampoo',
                'description' => 'Travel-size shampoo',
                'price' => 30.00,
                'is_consumable' => true,
                'stock_quantity' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Conditioner',
                'description' => 'Travel-size conditioner',
                'price' => 30.00,
                'is_consumable' => true,
                'stock_quantity' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Lotion',
                'description' => 'Travel-size body lotion',
                'price' => 35.00,
                'is_consumable' => true,
                'stock_quantity' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Other amenities (consumable)
            [
                'name' => 'Bottled Water',
                'description' => '500ml bottled water',
                'price' => 20.00,
                'is_consumable' => true,
                'stock_quantity' => 200,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tissue Roll',
                'description' => 'Standard tissue roll',
                'price' => 15.00,
                'is_consumable' => true,
                'stock_quantity' => 50,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('inventory')->insert($amenities);
    }
}
