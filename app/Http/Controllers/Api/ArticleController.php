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
}
