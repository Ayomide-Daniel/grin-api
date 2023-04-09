<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasUUID
{
    /**
     * Boot functions from Laravel.
     */
    protected static function bootHasUUID(): void
    {
        static::creating(function (Model $model) {
            $model->primaryKey = 'id';
            $model->keyType = 'string'; // In Laravel 6.0+ make sure to also set $keyType
            $model->incrementing = false;

            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
?>