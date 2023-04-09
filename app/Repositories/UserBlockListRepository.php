<?php

namespace App\Repositories;

use App\Models\UserBlockList;

class UserBlockListRepository extends BaseRepository
{
    public function __construct(private UserBlockList $model)
    {
        parent::__construct($model);
    }
}
