<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{

    use HasFactory;

    protected $table = 'farm_areas';

    protected $primaryKey = 'area_id';

    protected $fillable = [
        'farm_id',
        'area_name',
        'location',
        'description',
    ];
}
