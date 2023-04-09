<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tag',
        'type',
        'value',
        'status',
    ];
}