<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IUser;
use App\Exceptions\CannotFollowYourself;
use App\Repositories\Eloquent\Criteria\EagerLoad;

class UserController extends Controller
{
    protected $users;

    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $users = $this->users->withCriteria([
            new EagerLoad(['articles'])
        ])->all();

        return UserResource::collection($users);
    }

    public function findUser($id)
    {
        $user = $this->users->withCriteria([
            new EagerLoad(['articles'])
        ])->find($id);

        return new UserResource($user);
    }

    public function follow($id)
    {
        if(auth()->id() == $id) throw new CannotFollowYourself();
        $this->users->follow($id);
        $user = $this->users->withCriteria([
            new EagerLoad(['articles'])
        ])->find($id);

        return new UserResource($user);
    }

    public function checkIfUserHasFollowed($userId)
    {
        $isFollowed = $this->users->isFollowedByUser($userId);
        return response()->json(['followed' => $isFollowed], 200);
    }
}
