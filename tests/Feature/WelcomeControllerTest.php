<?php

use App\Models\Article;
use App\Models\User;
use App\Models\Category;

it('renders welcome page with articles', function () {
    $articles = Article::factory()->count(5)->create(['is_published' => true]);
    
    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertViewIs('welcome')
        ->assertViewHas('article')
        ->assertViewHas('articles');
});

it('renders welcome page with no articles', function () {
    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertViewIs('welcome');
});

it('caches welcome page articles', function () {
    $article = Article::factory()->create(['is_published' => true]);

    $this->get('/');

    expect(cache()->has('welcome_page_articles'))->toBeTrue();
});

it('loads article relationships', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();
    $article = Article::factory()->create([
        'is_published' => true,
        'author_id' => $author->id
    ]);
    $article->categories()->attach($category);

    $response = $this->get('/');

    $response->assertSuccessful();
    expect($response->viewData('article')->relationLoaded('author'))->toBeTrue();
    expect($response->viewData('article')->relationLoaded('categories'))->toBeTrue();
});

it('limits articles to 4 most recent', function () {
    $oldArticles = Article::factory()->count(5)->create([
        'is_published' => true,
        'created_at' => now()->subDays(10)
    ]);
    
    $newArticles = Article::factory()->count(4)->create([
        'is_published' => true,
        'created_at' => now()->subDays(1)
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    
    $allArticles = collect([$response->viewData('article')])->merge($response->viewData('articles'));
    expect($allArticles)->toHaveCount(4);
    
    $ids = $allArticles->pluck('id')->toArray();
    foreach ($newArticles as $article) {
        expect($ids)->toContain($article->id);
    }
});

it('orders articles by created_at desc', function () {
    $article1 = Article::factory()->create(['is_published' => true, 'created_at' => now()->subHours(3)]);
    $article2 = Article::factory()->create(['is_published' => true, 'created_at' => now()->subHours(2)]);
    $article3 = Article::factory()->create(['is_published' => true, 'created_at' => now()->subHours(1)]);
    $article4 = Article::factory()->create(['is_published' => true, 'created_at' => now()->subMinutes(30)]);

    $response = $this->get('/');

    $response->assertSuccessful();
    
    $allArticles = collect([$response->viewData('article')])->merge($response->viewData('articles'));
    $sortedIds = $allArticles->pluck('id')->toArray();
    $expectedOrder = [$article4->id, $article3->id, $article2->id, $article1->id];
    
    expect($sortedIds)->toBe($expectedOrder);
});