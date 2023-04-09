<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
        'status',
    ];
}
