<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    function index()
    {

        // Load data
        $articles = \App\Models\Article::query()
            ->select('id', 'title', 'author_id', 'content', 'slug')
            ->where('is_published', true)
            ->with('author:id,name','categories', 'media')
            ->paginate(100);
        // in case of category filtering: see whereHas('categories', function($query) use ($category) { $query->where('id', $category->id); })->get();)

        // Return view with data
        return view('articles.index', compact('articles'));

    }

    function show(string $slug)
    {
        //$article = Article::find($id);

        $article = Article::where('slug', $slug)->orWhere('id', $slug)->first();

        if(!$article) {
            return redirect()->route('articles.index');
        }

        return view('articles.show', compact('article'));
    }
}
