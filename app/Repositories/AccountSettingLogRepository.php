<?php

namespace App\Repositories;

use App\Models\AccountSettingLog;

class AccountSettingLogRepository extends BaseRepository
{
    public function __construct(private AccountSettingLog $model)
    {
        parent::__construct($model);
    }
}
