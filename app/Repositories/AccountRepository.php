<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository extends BaseRepository
{
    public function __construct(private Account $model)
    {
        parent::__construct($model);
    }
}
