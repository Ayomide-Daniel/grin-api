<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordReset extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
    ];
}