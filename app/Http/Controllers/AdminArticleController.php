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
        $articles = Article::where('author_id', auth()->id())->get();

        if (auth()->user()->is_admin) {
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
            'slug' => ['nullable', 'string', 'min:10', 'max:40'],
            'content' => ['nullable', 'string', 'min:10', 'max:500'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ]);

        $article = Article::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? null,
            'content' => $validated['content'] ?? null,
            'author_id' => auth()->id(),
        ]);

        if (isset($validated['categories'])) {
            $article->categories()->sync($validated['categories']);
        } else {
            $article->categories()->sync([]);
        }

        cache()->forget('welcome_page_articles');

        return redirect('/admin/articles');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        if (! $article->canBeManagedBy(auth()->user())) {
            abort(403);
        }

        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        if (! $article->canBeManagedBy(auth()->user())) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:10', 'max:40'],
            'slug' => ['nullable', 'string', 'min:10', 'max:40'],
            'content' => ['nullable', 'string', 'min:10', 'max:500'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'categories' => ['nullable'],
            'author_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        if ($request->has('categories')) {
            $article->categories()->sync($validated['categories']);
            unset($validated['categories']);
        } else {
            $article->categories()->sync([]);
        }

        // First process the file and upload it and get reference
        if ($request->hasFile('photo')) {
            $article->media->each->delete();
            $article->addMediaFromRequest('photo')->toMediaCollection();
            unset($validated['photo']);
        }

        $article->update($validated);

        cache()->forget('welcome_page_articles');

        // add reference to your article
        return redirect('/admin/articles');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if (! $article->canBeManagedBy(auth()->user())) {
            abort(403);
        }

        $article->delete();

        cache()->forget('welcome_page_articles');

        return redirect('/admin/articles');
    }
}
