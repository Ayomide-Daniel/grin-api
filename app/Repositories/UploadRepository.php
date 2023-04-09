<?php

namespace App\Repositories;

use App\Models\Upload;

class UploadRepository extends BaseRepository
{
    public function __construct(private Upload $model)
    {
        parent::__construct($model);
    }
}