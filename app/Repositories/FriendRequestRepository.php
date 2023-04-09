<?php

namespace App\Repositories;

use App\Models\FriendRequest;

class FriendRequestRepository extends BaseRepository
{
    public function __construct(private FriendRequest $model)
    {
        parent::__construct($model);
    }
}
