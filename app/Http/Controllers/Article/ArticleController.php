<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Repositories\Contracts\IArticle;
use App\Repositories\Eloquent\Criteria\{
    LatestFirst,
    ForUser,
    EagerLoad
};

class ArticleController extends Controller
{
    protected $articles;

    public function __construct(IArticle $articles)
    {
        $this->articles = $articles;
    }

    public function index()
    {
        $articles = $this->articles->withCriteria([
            new LatestFirst(),
            // new ForUser(2)
            new EagerLoad(['user'])
        ])->all();
        return ArticleResource::collection($articles);
    }

    public function findArticle($id)
    {
        $article = $this->articles->withCriteria([
            new EagerLoad(['user'])
        ])->find($id);

        return new ArticleResource($article);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'max:50'],
            'body' => ['required', 'max:500'],
            'tags' => ['required']
        ]);

        $article = $this->articles->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body
        ]);
        $article->tag($request->tags);

        return response()->json($article, 200);
    }

    public function update(Request $request, $id)
    {
        $article = $this->articles->find($id);
        $this->authorize('update', $article);

        $this->validate($request, [
            'title' => ['required', 'max:50', 'unique:articles,title,'.$id],
            'body' => ['required', 'max:500'],
            'tags' => ['required']
        ]);

        $article = $this->articles->update($id ,[
            'title' => $request->title,
            'body' => $request->body
        ]);
        $this->articles->applyTags($id, $request->tags);

        return new ArticleResource($article);
    }

    public function destroy($id)
    {
        $article = $this->articles->find($id);
        $this->authorize('delete', $article);
        $this->articles->delete($id);

        return response()->json(["message" => "投稿を削除しました。"], 200);
    }

    public function like($id)
    {
        $this->articles->like($id);
        $article = $this->articles->withCriteria([
            new EagerLoad(['user'])
        ])->find($id);

        return new ArticleResource($article);
    }

    public function checkIfUserHasLiked($articleId)
    {
        $isLiked = $this->articles->isLikedByUser($articleId);
        return response()->json(['liked' => $isLiked], 200);
    }
}
