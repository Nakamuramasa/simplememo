<?php

namespace App\Http\Controllers\Article;

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
}
