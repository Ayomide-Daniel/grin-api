<?php

namespace App\Repositories;

use App\Models\AccountSetting;

class AccountSettingRepository extends BaseRepository
{
    public function __construct(private AccountSetting $model)
    {
        parent::__construct($model);
    }
}
