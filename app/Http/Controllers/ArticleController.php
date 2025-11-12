<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    function index()
    {
        // Load data
        $articles = \App\Models\Article::all();

        // Return view with data
        return view('articles.index', compact('articles'));

    }

    function show(int $id)
    {
        $article = Article::find($id);

        return view('articles.show', compact('article'));
    }
}
