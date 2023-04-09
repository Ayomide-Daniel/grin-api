<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upload extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'tag',
        'value',
        'url',
    ];

    /**
     * @return BelongsTo
     */
}