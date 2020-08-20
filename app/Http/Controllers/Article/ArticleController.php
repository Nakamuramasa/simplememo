<?php

namespace App\Http\Controllers\Article;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'max:50'],
            'body' => ['required', 'max:500']
        ]);

        $article = auth()->user()->articles()->create([
            'title' => $request->title,
            'body' => $request->body
        ]);

        return response()->json($article, 200);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $this->authorize('update', $article);

        $this->validate($request, [
            'title' => ['required', 'max:50', 'unique:articles,title,'.$id],
            'body' => ['required', 'max:500']
        ]);

        $article->update([
            'title' => $request->title,
            'body' => $request->body
        ]);

        return new ArticleResource($article);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $this->authorize('delete', $article);
        $article->delete();

        return response()->json(["message" => "投稿を削除しました。"], 200);
    }
}
