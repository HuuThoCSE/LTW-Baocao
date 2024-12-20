<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarnModel extends Model
{
    use HasFactory;

    protected $table = 'farm_barns';

    protected $primaryKey = 'barn_id';

    protected $fillable = [
        'barn_id',
        'farm_id',
        'zone_id',
        'barn_name',
        'location',
        'description',
        'area_id',
    ];

    protected $hidden = [];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'barn_id');
    }

}
