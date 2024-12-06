<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'farm_id';

    protected $fillable = [
        'farm_name',
        'location',
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class, 'farm_id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'farm_id');
    }
}
