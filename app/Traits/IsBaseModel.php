<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait IsBaseModel
{
    /**
     * The date format.
     * 
     * @var string
     */
    protected $dateFormat = 'U'; // this will give you a timestamp

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected static function booted(): void
    {
        static::creating(function (Model $model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
?>