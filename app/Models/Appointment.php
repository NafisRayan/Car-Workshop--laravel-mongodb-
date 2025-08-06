<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Appointment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'appointments';

    protected $fillable = [
        'client_name',
        'client_address',
        'client_phone',
        'car_license_no',
        'car_engine_no',
        'appointment_date',
        'mechanic_id',
        'mechanic_name'
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }
}
