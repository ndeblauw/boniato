<?php

use App\Models\Article;
use App\Models\User;

test('index displays published articles page', function () {
    $user = User::factory()->create();
    Article::factory()->create([
        'is_published' => true,
        'author_id' => $user->id,
    ]);

    $response = $this->get(route('articles.index'));

    $response->assertStatus(200);
});

test('show displays article by slug', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create([
        'slug' => 'test-article-slug',
        'author_id' => $user->id,
    ]);

    $response = $this->get(route('articles.show', $article->slug));

    $response->assertSuccessful();
});

test('show displays article by id', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $user->id]);

    $response = $this->get(route('articles.show', $article->id));

    $response->assertSuccessful();
});

test('show redirects when article not found', function () {
    $response = $this->get(route('articles.show', 'non-existent-slug'));

    $response->assertRedirect(route('articles.index'));
});
