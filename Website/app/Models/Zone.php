<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $primaryKey = 'zone_id';

    protected $fillable = [
        'farm_id',
        'zone_name',
        'description',
    ];

    public function farm()
    {
        return $this->belongsTo(FarmModel::class, 'farm_id');
    }

    public function barns()
    {
        return $this->hasMany(BarnModel::class, 'zone_id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'zone_id');
    }
}
