<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MechanicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Mechanic::create(['name' => 'Mechanic A', 'appointments_count' => 0]);
        \App\Models\Mechanic::create(['name' => 'Mechanic B', 'appointments_count' => 0]);
        \App\Models\Mechanic::create(['name' => 'Mechanic C', 'appointments_count' => 0]);
        \App\Models\Mechanic::create(['name' => 'Mechanic D', 'appointments_count' => 0]);
        \App\Models\Mechanic::create(['name' => 'Mechanic E', 'appointments_count' => 0]);
    }
}
