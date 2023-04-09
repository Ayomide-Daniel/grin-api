<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountSettingLog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "account_setting_id",
        "tag",
        "value",
    ];
}