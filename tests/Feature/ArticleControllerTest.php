<?php

use App\Models\Article;
use App\Models\User;
use App\Models\Category;

it('displays paginated published articles', function () {
    $articles = Article::factory()->count(10)->create(['is_published' => true]);
    $unpublishedArticle = Article::factory()->create(['is_published' => false]);

    $response = $this->get('/articles');

    $response->assertSuccessful()
        ->assertViewIs('articles.index')
        ->assertViewHas('articles');
    
    $articlesData = $response->viewData('articles');
    expect($articlesData)->toHaveCount(10);
    expect($articlesData->first()->is_published)->toBeTrue();
});

it('loads article relationships on index', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();
    $article = Article::factory()->create([
        'is_published' => true,
        'author_id' => $author->id
    ]);
    $article->categories()->attach($category);

    $response = $this->get('/articles');

    $response->assertSuccessful();
    $articles = $response->viewData('articles');
    $firstArticle = $articles->first();
    
    expect($firstArticle->relationLoaded('author'))->toBeTrue();
    expect($firstArticle->relationLoaded('categories'))->toBeTrue();
});

it('selects correct columns on index', function () {
    Article::factory()->create(['is_published' => true]);

    $response = $this->get('/articles');

    $response->assertSuccessful();
    $articles = $response->viewData('articles');
    $firstArticle = $articles->first();
    
    expect($firstArticle)->toHaveKeys(['id', 'title', 'author_id', 'content', 'slug']);
});

it('displays article by slug', function () {
    $article = Article::factory()->create(['is_published' => true]);

    $response = $this->get("/articles/{$article->slug}");

    $response->assertSuccessful()
        ->assertViewIs('articles.show')
        ->assertViewHas('article', $article);
});

it('displays article by id', function () {
    $article = Article::factory()->create(['is_published' => true]);

    $response = $this->get("/articles/{$article->id}");

    $response->assertSuccessful()
        ->assertViewIs('articles.show')
        ->assertViewHas('article', $article);
});

it('redirects to index when article not found', function () {
    $response = $this->get('/articles/nonexistent-slug');

    $response->assertRedirect('/articles');
});

it('redirects to index when slug is empty string', function () {
    $response = $this->get('/articles/');

    $response->assertRedirect('/articles');
});

it('finds article by slug when id is passed as string', function () {
    $article = Article::factory()->create([
        'is_published' => true,
        'slug' => 'test-article'
    ]);

    $response = $this->get('/articles/test-article');

    $response->assertSuccessful()
        ->assertViewHas('article');
});

it('prioritizes slug over id when both could match', function () {
    $article1 = Article::factory()->create([
        'is_published' => true,
        'slug' => '123'
    ]);
    $article2 = Article::factory()->create([
        'is_published' => true,
        'id' => 123
    ]);

    $response = $this->get('/articles/123');

    $response->assertSuccessful()
        ->assertViewHas('article', function ($article) use ($article1) {
            return $article->id === $article1->id;
        });
});

it('shows unpublished article when accessed directly', function () {
    $article = Article::factory()->create(['is_published' => false]);

    $response = $this->get("/articles/{$article->slug}");

    $response->assertSuccessful()
        ->assertViewHas('article', $article);
});

it('handles articles with null slug', function () {
    $article = Article::factory()->create([
        'is_published' => true,
        'slug' => null
    ]);

    $response = $this->get("/articles/{$article->id}");

    $response->assertSuccessful()
        ->assertViewHas('article', $article);
});