<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepository extends BaseRepository
{
    public function __construct(private Location $model)
    {
        parent::__construct($model);
    }
}
