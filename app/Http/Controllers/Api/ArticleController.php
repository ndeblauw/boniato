<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleIndexResource;
use App\Http\Resources\ArticleShowResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $perPage = request()->get('per_page', 5);

        $articles = Article::query()
            ->select(['id', 'title', 'author_id', 'content'])
            ->with('author:id,name')
            ->where('is_published', true)
            ->paginate($perPage);

        return ArticleIndexResource::collection($articles);
    }

    public function show(int $id)
    {
        $article = Article::query()
            ->select(['id', 'title', 'author_id', 'content'])
            ->with('author:id,name')
            ->where('is_published', true)
            ->find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        return new ArticleShowResource($article);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:10', 'max:40'],
            'slug' => ['nullable', 'string', 'min:10', 'max:40'],
            'content' => ['nullable', 'string', 'min:10', 'max:500'],
            'file' => ['nullable', 'file', 'mimes:jpg,png,pdf', 'max:2048'],
        ]);

        $article = Article::create($validated + ['author_id' => auth()->id(), 'is_published' => false]);

        return response()->json(new ArticleShowResource($article), 201);
    }
}
