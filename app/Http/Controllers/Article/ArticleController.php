<?php

namespace App\Http\Controllers\Article;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $this->validate($request, [
            'title' => ['required', 'max:50', 'unique:articles,title,'.$id],
            'body' => ['required', 'max:500']
        ]);

        $article = Article::find($id);

        $article->update([
            'title' => $request->title,
            'body' => $request->body
        ]);

        return response()->json($article, 200);
    }
}
