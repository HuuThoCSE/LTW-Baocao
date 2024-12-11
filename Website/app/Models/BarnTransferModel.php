<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarnTransferModel extends Model
{

    use HasFactory;

    protected $table = 'barn_transfers';

    protected $fillable = [
        'goat_id',
        'old_barn_id',
        'new_barn_id',
        'transferred_by',
    ];

    public function oldBarn()
    {
        return $this->belongsTo(BarnModel::class, 'old_barn_id');
    }

    public function newBarn()
    {
        return $this->belongsTo(Barn::class, 'new_barn_id');
    }

    public function transferredBy()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }
}
