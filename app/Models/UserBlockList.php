<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserBlockList extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "blocked_user_id",
    ];
}