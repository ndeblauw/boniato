<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        // Only users that have at least one published article
        $authors = User::whereHas('articles', function ($q) {
            $q->where('is_published', true);
        })
            ->withCount(['articles' => function ($q) {
                $q->where('is_published', true);
            }])
            ->orderByDesc('articles_count')
            ->get();

        return view('authors.index', compact('authors'));
    }

    public function show(User $author)
    {
        // Load published articles with the same relations as article index
        $author->load(['articles' => function ($q) {
            $q->where('is_published', true)
                ->with('categories', 'media');
        }]);

        return view('authors.show', compact('author'));
    }
}
