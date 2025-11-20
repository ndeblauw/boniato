<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::where('author_id', auth()->id() )->get();

        if(auth()->user()->is_admin) {
            $articles = Article::all();
        }

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:10', 'max:40'],
            'content' => ['nullable', 'string', 'min:10', 'max:500'],
        ]);

        Article::create($validated + ['author_id' => 1]);

        return redirect('/admin/articles');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::find($id);

        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::find($id);

        if(!$article->canBeManagedBy(auth()->user())) {
            abort(403);
        }

        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::find($id);

        if(!$article->canBeManagedBy(auth()->user())) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:10', 'max:40'],
            'content' => ['nullable', 'string', 'min:10', 'max:500'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // First process the file and upload it and get reference
        if($request->hasFile('photo')) {
            $article->media->each->delete();
            $article->addMediaFromRequest('photo')->toMediaCollection();
            unset($validated['photo']);
        }

        // add reference to your article

        $article->update($validated + ['photo_path' => $path]);
        return redirect('/admin/articles');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);

        if(!$article->canBeManagedBy(auth()->user())) {
            abort(403);
        }

        $article->delete();

        return redirect('/admin/articles');
    }
}
