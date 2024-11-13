<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDevice extends Model
{
    use HasFactory;

    protected $primaryKey = 'type_device_id';

    protected $fillable = [
        'type_device_code',
        'type_device_name',
        'description',
    ];

    public function devices()
    {
        return $this->hasMany(Device::class, 'type_device_id');
    }
}
