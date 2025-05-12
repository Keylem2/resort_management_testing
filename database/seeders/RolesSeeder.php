<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Populate roles for Finance department
    Role::create([
        'name' => 'Finance Head',
        'department' => 'Finance',
    ]);

    Role::create([
        'name' => 'Inventory Manager',
        'department' => 'Finance',
    ]);

    Role::create([
        'name' => 'Sales Clerk',
        'department' => 'Finance',
    ]);
}
}

// THIS SEEDER IS NOT USED YET