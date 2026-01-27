<?php

use App\Models\Article;
use App\Models\Comment;

it('creates a valid comment', function () {
    $article = Article::factory()->create();

    $response = $this->post('/comments', [
        'content' => 'This is a valid comment with at least 10 characters.',
        'article_id' => $article->id,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('comments', [
        'content' => 'This is a valid comment with at least 10 characters.',
        'article_id' => $article->id,
    ]);
});

it('requires content field', function () {
    $article = Article::factory()->create();

    $response = $this->post('/comments', [
        'article_id' => $article->id,
    ]);

    $response->assertSessionHasErrors('content');
});

it('requires article_id field', function () {
    $response = $this->post('/comments', [
        'content' => 'This is a valid comment with at least 10 characters.',
    ]);

    $response->assertSessionHasErrors('article_id');
});

it('validates content minimum length', function () {
    $article = Article::factory()->create();

    $response = $this->post('/comments', [
        'content' => 'Too short',
        'article_id' => $article->id,
    ]);

    $response->assertSessionHasErrors('content');
});

it('validates content maximum length', function () {
    $article = Article::factory()->create();
    $longContent = str_repeat('a', 256);

    $response = $this->post('/comments', [
        'content' => $longContent,
        'article_id' => $article->id,
    ]);

    $response->assertSessionHasErrors('content');
});

it('validates article_id exists', function () {
    $response = $this->post('/comments', [
        'content' => 'This is a valid comment with at least 10 characters.',
        'article_id' => 999,
    ]);

    $response->assertSessionHasErrors('article_id');
});

it('validates article_id is integer', function () {
    $response = $this->post('/comments', [
        'content' => 'This is a valid comment with at least 10 characters.',
        'article_id' => 'not-an-integer',
    ]);

    $response->assertSessionHasErrors('article_id');
});

it('creates comment with valid edge case content length', function () {
    $article = Article::factory()->create();
    $minContent = str_repeat('a', 10);
    $maxContent = str_repeat('a', 255);

    $response1 = $this->post('/comments', [
        'content' => $minContent,
        'article_id' => $article->id,
    ]);

    $response2 = $this->post('/comments', [
        'content' => $maxContent,
        'article_id' => $article->id,
    ]);

    $response1->assertRedirect();
    $response2->assertRedirect();
    
    $this->assertDatabaseHas('comments', [
        'content' => $minContent,
        'article_id' => $article->id,
    ]);
    $this->assertDatabaseHas('comments', [
        'content' => $maxContent,
        'article_id' => $article->id,
    ]);
});

it('redirects back after successful comment creation', function () {
    $article = Article::factory()->create();

    $response = $this->post('/comments', [
        'content' => 'This is a valid comment with at least 10 characters.',
        'article_id' => $article->id,
    ]);

    $response->assertRedirect();
});

it('handles multiple comments on same article', function () {
    $article = Article::factory()->create();

    $response1 = $this->post('/comments', [
        'content' => 'First comment with enough characters.',
        'article_id' => $article->id,
    ]);

    $response2 = $this->post('/comments', [
        'content' => 'Second comment also with enough characters.',
        'article_id' => $article->id,
    ]);

    $response1->assertRedirect();
    $response2->assertRedirect();
    
    $this->assertDatabaseCount('comments', 2);
    $this->assertDatabaseHas('comments', ['article_id' => $article->id, 'content' => 'First comment with enough characters.']);
    $this->assertDatabaseHas('comments', ['article_id' => $article->id, 'content' => 'Second comment also with enough characters.']);
});