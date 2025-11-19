<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class AdminArticleToggleIsPublishedController extends Controller
{
    public function __invoke(string $id)
    {
        $article = Article::find($id);

        $article->update([
            'is_published' => !$article->is_published,
        ]);

        return redirect()->back();
    }
}
