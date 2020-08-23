<?php

namespace App\Repositories\Eloquent;

use App\Models\Follow;
use App\Repositories\Contracts\IFollow;
use App\Repositories\Eloquent\BaseRepository;

class FollowRepository extends BaseRepository implements IFollow
{
    public function model()
    {
        return Follow::class;
    }
}
