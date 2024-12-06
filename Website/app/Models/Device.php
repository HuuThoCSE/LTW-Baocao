<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $primaryKey = 'device_id';

    protected $fillable = [
        'farm_id',
        'zone_id',
        'barn_id',
        'type_device_id',
        'device_name',
        'status',
        'last_maintenance',
        'next_maintenance',
    ];

    public function farm()
    {
        return $this->belongsTo(FarmModel::class, 'farm_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function barn()
    {
        return $this->belongsTo(BarnModel::class, 'barn_id');
    }

    public function typeDevice()
    {
        return $this->belongsTo(TypeDevice::class, 'type_device_id');
    }
}
