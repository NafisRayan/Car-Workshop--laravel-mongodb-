<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Mechanic;

echo "Inserting mechanic data...\n";

try {
    Mechanic::create(['name' => 'Mechanic A', 'appointments_count' => 0]);
    Mechanic::create(['name' => 'Mechanic B', 'appointments_count' => 0]);
    Mechanic::create(['name' => 'Mechanic C', 'appointments_count' => 0]);
    Mechanic::create(['name' => 'Mechanic D', 'appointments_count' => 0]);
    Mechanic::create(['name' => 'Mechanic E', 'appointments_count' => 0]);
    echo "Mechanic data inserted successfully.\n";
} catch (\Exception $e) {
    echo "Error inserting data: " . $e->getMessage() . "\n";
}