<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Mechanic extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'mechanics';

    protected $fillable = [
        'name',
        'appointments_count'
    ];
}
