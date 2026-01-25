<?php

namespace App\Http\Controllers;

use App\Jobs\InformAdminsOfNewPublicationJob;
use App\Models\Article;

class AdminArticleToggleIsPublishedController extends Controller
{
    public function __invoke(string $id)
    {
        $article = Article::find($id);

        $article->update([
            'is_published' => ! $article->is_published,
        ]);

        if ($article->is_published) {
            InformAdminsOfNewPublicationJob::dispatch($article, auth()->user());
        }

        return redirect()->back();
    }
}
