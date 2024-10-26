<?php

// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role',
    ];
    // app/Models/Role.php

public static function getRoleName($role)
{
    $roles = [
        0 => 'Administrator',
        1 => 'Admin',
        2 => 'Nông dân',
        3 => 'Khách hàng',
    ];

    return $roles[$role] ?? 'Unknown Role';
}

}
