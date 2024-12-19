<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorDataModel extends Model
{

    use HasFactory;

    protected $table = 'sensor_data';

    protected $fillable = [
        'sensor_id',
        'temperature',
        'humidity',
        'recorded_at',
    ];

    public $timestamps = true;
}