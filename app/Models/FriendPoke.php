<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FriendPoke extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "friend_request_id",
        "sender_id",
        "receiver_id",
    ];
}