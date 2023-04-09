<?php

namespace App\Repositories;

use App\Models\FriendPoke;
use App\Repositories\BaseRepository;

class FriendPokeRepository extends BaseRepository
{
    public function __construct(private FriendPoke $model)
    {
        parent::__construct($model);
    }
}
