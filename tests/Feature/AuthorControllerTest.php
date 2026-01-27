<?php

use App\Models\User;
use App\Models\Article;
use App\Models\Category;

it('displays authors with published articles only', function () {
    $authorWithArticles = User::factory()->create();
    $authorWithoutArticles = User::factory()->create();
    
    Article::factory()->count(3)->create([
        'author_id' => $authorWithArticles->id,
        'is_published' => true
    ]);
    
    Article::factory()->count(2)->create([
        'author_id' => $authorWithArticles->id,
        'is_published' => false
    ]);

    $response = $this->get('/authors');

    $response->assertSuccessful()
        ->assertViewIs('authors.index')
        ->assertViewHas('authors');
    
    $authors = $response->viewData('authors');
    expect($authors)->toHaveCount(1);
    expect($authors->first()->id)->toBe($authorWithArticles->id);
});

it('orders authors by published articles count desc', function () {
    $author1 = User::factory()->create();
    $author2 = User::factory()->create();
    $author3 = User::factory()->create();
    
    Article::factory()->count(5)->create([
        'author_id' => $author1->id,
        'is_published' => true
    ]);
    
    Article::factory()->count(3)->create([
        'author_id' => $author2->id,
        'is_published' => true
    ]);
    
    Article::factory()->count(7)->create([
        'author_id' => $author3->id,
        'is_published' => true
    ]);

    $response = $this->get('/authors');

    $response->assertSuccessful();
    $authors = $response->viewData('authors');
    
    expect($authors[0]->id)->toBe($author3->id);
    expect($authors[1]->id)->toBe($author1->id);
    expect($authors[2]->id)->toBe($author2->id);
});

it('includes articles_count in authors index', function () {
    $author = User::factory()->create();
    Article::factory()->count(4)->create([
        'author_id' => $author->id,
        'is_published' => true
    ]);
    Article::factory()->count(2)->create([
        'author_id' => $author->id,
        'is_published' => false
    ]);

    $response = $this->get('/authors');

    $response->assertSuccessful();
    $authors = $response->viewData('authors');
    $firstAuthor = $authors->first();
    
    expect($firstAuthor->articles_count)->toBe(4);
});

it('displays author with published articles only', function () {
    $author = User::factory()->create();
    
    $publishedArticle1 = Article::factory()->create([
        'author_id' => $author->id,
        'is_published' => true
    ]);
    $publishedArticle2 = Article::factory()->create([
        'author_id' => $author->id,
        'is_published' => true
    ]);
    $unpublishedArticle = Article::factory()->create([
        'author_id' => $author->id,
        'is_published' => false
    ]);

    $response = $this->get("/authors/{$author->id}");

    $response->assertSuccessful()
        ->assertViewIs('authors.show')
        ->assertViewHas('author', function ($viewAuthor) use ($author) {
            return $viewAuthor->id === $author->id;
        });
    
    $viewAuthor = $response->viewData('author');
    expect($viewAuthor->articles)->toHaveCount(2);
    expect($viewAuthor->articles->pluck('id'))->toContain($publishedArticle1->id, $publishedArticle2->id);
    expect($viewAuthor->articles->pluck('id'))->not->toContain($unpublishedArticle->id);
});

it('loads article relationships on author show', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();
    
    $article = Article::factory()->create([
        'author_id' => $author->id,
        'is_published' => true
    ]);
    $article->categories()->attach($category);

    $response = $this->get("/authors/{$author->id}");

    $response->assertSuccessful();
    $viewAuthor = $response->viewData('author');
    $firstArticle = $viewAuthor->articles->first();
    
    expect($firstArticle->relationLoaded('categories'))->toBeTrue();
    expect($firstArticle->relationLoaded('media'))->toBeTrue();
});

it('displays author with no published articles', function () {
    $author = User::factory()->create();
    Article::factory()->count(3)->create([
        'author_id' => $author->id,
        'is_published' => false
    ]);

    $response = $this->get("/authors/{$author->id}");

    $response->assertSuccessful()
        ->assertViewHas('author', $author);
    
    $viewAuthor = $response->viewData('author');
    expect($viewAuthor->articles)->toHaveCount(0);
});

it('handles non-existent author id', function () {
    $response = $this->get('/authors/999');

    $response->assertNotFound();
});

it('handles author model binding correctly', function () {
    $author = User::factory()->create();

    $response = $this->get("/authors/{$author->id}");

    $response->assertSuccessful()
        ->assertViewHas('author', $author);
});