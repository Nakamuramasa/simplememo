<?php

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Repositories\Contracts\IArticle;
use App\Repositories\Eloquent\BaseRepository;

class ArticleRepository extends BaseRepository implements IArticle
{
    public function model()
    {
        return Article::class;
    }

    public function applyTags($id, array $data)
    {
        $article = $this->find($id);
        $article->retag($data);
    }

    public function like($id)
    {
        $article = $this->model->findOrFail($id);
        if($article->isLikedByUser(auth()->id())){
            $article->unlike();
        }else{
            $article->like();
        }
    }
}
