<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{

    use HasFactory;

    // Tên bảng trong CSDL
    protected $table = 'farm_log';

    protected $primaryKey = 'farm_log_id';

    protected $fillable = [
        'user_id',
        'description',
    ];

    // Tự động thêm timestamps (created_at, updated_at)
    public $timestamps = true;
}
