<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountSetting extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "tag",
        "value",
    ];
}