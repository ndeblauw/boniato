<?php

use App\Models\Article;
use App\Models\User;

test('welcome page displays recent articles', function () {
    $user = User::factory()->create();
    $articles = Article::factory()->count(5)->create([
        'author_id' => $user->id,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
});
