<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendRequest extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "sender_id",
        "receiver_id",
        "status"
    ];
}