<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barn extends Model
{
    use HasFactory;

    protected $primaryKey = 'barn_id';

    protected $fillable = [
        'zone_id',
        'barn_name',
        'location',
        'description',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'barn_id');
    }
}
