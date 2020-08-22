<?php

namespace App\Repositories\Contracts;

interface IUser
{
    public function follow($id);
    public function isFollowedByUser($id);
}
