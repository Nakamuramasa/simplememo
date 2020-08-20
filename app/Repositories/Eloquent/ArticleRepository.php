<?php

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Repositories\Contracts\IArticle;

class ArticleRepository implements IArticle
{
    public function all()
    {
        return Article::all();
    }
}
