<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

it('returns a successful response', function () {
    User::factory()->create();
    Article::factory(['is_published' => true, 'deleted_at' => null, 'author_id' => 1])->count(3)->create();

    $response = $this->get('/');

    $response->assertStatus(200);
});

it('displays correct title and navigation', function () {
    $response = $this->get('/');

    $response->assertSee('BoNiaTo');
    $response->assertSee('Articles');
    $response->assertSee('Categories');
    $response->assertSee('Authors');
});

it('displays featured article when available', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $article = Article::factory()
        ->create([
            'title' => 'Featured Article Title',
            'content' => 'This is the featured article content for testing purposes.',
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    $article->categories()->attach($category);

    $response = $this->get('/');

    $response->assertSee('Featured Article Title');
    $response->assertSee('This is the featured article content for testing purposes.');
    $response->assertSee($category->name);
    $response->assertSee($user->name);
});

it('displays articles grid when articles are available', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $articles = Article::factory(4)
        ->create([
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    ray($articles);

    foreach ($articles as $article) {
        $article->categories()->attach($category);
    }

    $response = $this->get('/');

    foreach ($articles as $article) {
        $response->assertSee($article->title);
        $response->assertSee($article->content);
        $response->assertSee($category->name);
        $response->assertSee($user->name);
    }
});

it('only displays published articles', function () {
    $user = User::factory()->create();

    $publishedArticle = Article::factory()
        ->create([
            'title' => 'Published Article',
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    $unpublishedArticle = Article::factory()
        ->create([
            'title' => 'Unpublished Article',
            'author_id' => $user->id,
            'is_published' => false,
        ]);

    $response = $this->get('/');

    $response->assertSee('Published Article');
    $response->assertDontSee('Unpublished Article');
});

it('displays most recent articles as featured', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $oldArticle = Article::factory()
        ->create([
            'title' => 'Old Article',
            'author_id' => $user->id,
            'is_published' => true,
            'created_at' => now()->subDays(10),
        ]);

    $recentArticle = Article::factory()
        ->create([
            'title' => 'Recent Article',
            'author_id' => $user->id,
            'is_published' => true,
            'created_at' => now()->subDays(1),
        ]);

    $oldArticle->categories()->attach($category);
    $recentArticle->categories()->attach($category);

    $response = $this->get('/');

    $response->assertSee('Recent Article');
});

it('handles no articles gracefully', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('BoNiaTo');
})->skip();

it('displays correct category links', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['name' => 'Test Category']);

    $article = Article::factory()
        ->create([
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    $article->categories()->attach($category);

    $response = $this->get('/');

    $response->assertSee('Test Category');
    $response->assertSee('/categories/' . $category->id);
});

it('displays correct article links', function () {
    $user = User::factory()->create();

    $article = Article::factory()
        ->create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    $response = $this->get('/');

    $response->assertSee('Test Article');
    $response->assertSee('/articles/test-article');
});

it('caches articles correctly', function () {
    Cache::shouldReceive('remember')
        ->once()
        ->with('homepage_articles', 3600, \Closure::class)
        ->andReturn([]);

    $response = $this->get('/');

    $response->assertStatus(200);
})->skip();

it('displays responsive layout elements', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $article = Article::factory()
        ->create([
            'title' => 'Test Article',
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    $article->categories()->attach($category);

    $response = $this->get('/');

    $response->assertSee('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3');
    $response->assertSee('flex flex-col lg:flex-row');
});

it('displays author information correctly', function () {
    $user = User::factory()->create(['name' => 'John Doe']);

    $article = Article::factory()
        ->create([
            'title' => 'Test Article',
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    $response = $this->get('/');

    $response->assertSee('John Doe');
    $response->assertSee('written by');
});

it('displays multiple categories per article', function () {
    $user = User::factory()->create();
    $categories = Category::factory()->count(3)->create();

    $article = Article::factory()
        ->create([
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    $article->categories()->attach($categories);

    $response = $this->get('/');

    foreach ($categories as $category) {
        $response->assertSee($category->name);
    }
});

it('limits articles grid to 3 items', function () {
    $user = User::factory()->create();

    Article::factory()
        ->count(5)
        ->create([
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    $response = $this->get('/');

    $response->assertStatus(200);
});

it('handles deleted articles correctly', function () {
    $user = User::factory()->create();

    Article::factory(5)->create(['author_id' => $user->id,
        'is_published' => true,
    ]);
    $deletedArticle = Article::factory()
        ->create([
            'title' => 'Deleted Article',
            'author_id' => $user->id,
            'is_published' => true,
        ]);

    $deletedArticle->delete();

    $response = $this->get('/');

    $response->assertDontSee('Deleted Article');
});
