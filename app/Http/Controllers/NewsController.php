<?php

namespace App\Http\Controllers;

use App\Models\Article;

class NewsController extends Controller
{
    public function show(Article $article)
    {
        return view('news.show', compact('article'));
    }
}
