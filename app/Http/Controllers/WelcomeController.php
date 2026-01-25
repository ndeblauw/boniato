<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        // Load 4 most recent articles
        $articles = cache()->remember('welcome_page_articles', config('app.cache_ttl'), function () {
            return \App\Models\Article::query()
                ->with('author:id,name', 'media', 'categories')
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
        });

        $article = $articles->shift();

        return view('welcome', compact('article', 'articles'));
    }
}
