<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{

    use HasFactory;

    protected $primaryKey = 'breed_id';

    protected $fillable = [
        'farm_id',
        'breed_name_eng',
        'breed_name_vie',
        'description',
    ];
}
