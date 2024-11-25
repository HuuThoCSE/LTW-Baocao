<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{

    use HasFactory;

    protected $table = 'sensor_data'; // Bảng tương ứng
    protected $fillable = ['sensor_id', 'sensor_type', 'value']; // Các cột có thể insert
}
