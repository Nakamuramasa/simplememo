<?php

namespace App\Models\Traits;

use App\Models\Follow;

trait Following
{
    public static function bootFollowing()
    {
        static::deleting(function($model){
            $model->removeFollows();
        });
    }

    public function removeFollows()
    {
        if($this->follows()->count()){
            $this->follows()->delete();
        }
    }

    public function follows()
    {
        return $this->morphMany(Follow::class, 'following');
    }

    public function follow()
    {
        if(! auth()->check()) return;
        if($this->isFollowedByUser(auth()->id())) return;

        $this->follows()->create(['user_id' => auth()->id()]);
    }

    public function unfollow()
    {
        if(! auth()->check()) return;
        if(! $this->isFollowedByUser(auth()->id())) return;

        $this->follows()->where('user_id', auth()->id())->delete();
    }

    public function isFollowedByUser($user_id)
    {
        return (bool)$this->follows()->where('user_id', $user_id)->count();
    }
}
