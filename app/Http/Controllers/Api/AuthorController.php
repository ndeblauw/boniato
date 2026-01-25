<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorIndexResource;
use App\Http\Resources\AuthorShowResource;
use App\Models\User;

class AuthorController extends Controller
{
    public function index()
    {
        $perPage = request()->get('per_page', 5);

        $authors = User::query()
            ->paginate($perPage);

        return AuthorIndexResource::collection($authors);
    }

    public function show(int $id)
    {
        $author = User::query()
            ->with('articles')
            ->find($id);

        if (! $author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        return new AuthorShowResource($author);
    }
}
