<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function form(Request $request)
    {
        $valid = $request->validate([
            'title' => ['nullable', 'string', 'min:3'],
            'category' => ['nullable', 'integer'],
        ]);
        $title = $valid['title'] ?? '';
        $category = $valid['category'] ?? null;

        $articles = Article::query()
            ->where('title', 'like', "%{$title}%")
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('id', $category);
            })
            ->get();


        return view('search.form', compact('articles', 'title', 'category'));
    }
}
