<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use MongoDB\Laravel\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::collection('appointments', function (Blueprint $collection) {
            $collection->unique(['client_phone', 'appointment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::collection('appointments', function (Blueprint $collection) {
            $collection->dropUnique(['client_phone', 'appointment_date']);
        });
    }
};
