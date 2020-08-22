<?php

namespace App\Models;

use App\Models\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentTaggable\Taggable;

class Article extends Model
{
    use Taggable, Likeable;

    protected $fillable = [
        'user_id', 'title', 'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
