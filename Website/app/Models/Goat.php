<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goat extends Model
{
    use HasFactory;

    protected $table = 'goats'; // Tên bảng trong cơ sở dữ liệu

    // Nếu không cần timestamps
    public $timestamps = false;
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farm_id', 'farm_id');
    }
}
