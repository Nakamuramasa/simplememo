<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements IUser
{
    public function model()
    {
        return User::class;
    }

    public function follow($id)
    {
        $user = $this->model->findOrFail($id);
        if($user->isFollowedByUser(auth()->id())){
            $user->unfollow();
        }else{
            $user->follow();
        }
    }

    public function isFollowedByUser($id)
    {
        $user = $this->model->findOrFail($id);
        return $user->isFollowedByUser(auth()->id());
    }
}
