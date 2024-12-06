<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoatModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'goat_id'; // Khóa chính

    protected $table = 'farm_goats'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'goat_name',
        'goat_age',
        'farm_id',
        'breed_id',
        'origin',
    ];

    // Nếu không cần timestamps
    public $timestamps = true;

    // Định nghĩa mối quan hệ với bảng 'farms'
    public function farm()
    {
        return $this->belongsTo(FarmModel::class, 'farm_id', 'farm_id');
    }

    // Định nghĩa mối quan hệ với bảng 'farm_breeds'
    public function breed()
    {
        return $this->belongsTo(BreedModel::class, 'breed_id', 'breed_id');
    }

    // Quan hệ một-nhiều với GoatWeight. Mỗi con dê có nhiều cân nặng trong lịch sử.
    public function weights()
    {
        return $this->hasMany(GoatWeightModel::class, 'goat_id');
    }
}
