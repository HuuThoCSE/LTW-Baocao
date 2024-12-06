<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoatWeightModel extends Model
{

    use HasFactory;

    protected $table = 'goat_weights';

    protected $primaryKey = 'goat_weight_id';

    protected $fillable = [
        'goat_id',
        'weight',
    ];

    // Quan hệ ngược lại với Goat
    public function goat()
    {
        return $this->belongsTo(GoatModel::class, 'goat_id');
    }
}
