<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeFoodModel extends Model
{
    use HasFactory;
	
    protected $table = 'type_foods';
    protected $primaryKey = 'type_food_id';
    protected $fillable = ['type_food_code', 'type_food_name_vn', 'type_food_name_el'];
    public function typefood()
    {
        return $this->hasMany(Device::class, 'type_food_id');
    }
    public $timestamps = false;
}
