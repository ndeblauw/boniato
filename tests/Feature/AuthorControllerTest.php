<?php

use App\Models\Article;
use App\Models\User;

test('index displays authors with published articles', function () {
    $authorWithPublished = User::factory()->create();
    Article::factory()->create([
        'author_id' => $authorWithPublished->id,
        'is_published' => true,
    ]);

    $authorWithoutPublished = User::factory()->create();
    Article::factory()->create([
        'author_id' => $authorWithoutPublished->id,
        'is_published' => false,
    ]);

    $response = $this->get(route('authors.index'));

    $response->assertStatus(200);
    $response->assertSeeText($authorWithPublished->name);
    $response->assertDontSeeText($authorWithoutPublished->name);
});

test('index orders authors by articles count', function () {
    $author1 = User::factory()->create();
    Article::factory()->count(3)->create([
        'author_id' => $author1->id,
        'is_published' => true,
    ]);

    $author2 = User::factory()->create();
    Article::factory()->count(1)->create([
        'author_id' => $author2->id,
        'is_published' => true,
    ]);

    $response = $this->get(route('authors.index'));

    $response->assertStatus(200);
    $content = $response->getContent();
    expect(strpos($content, $author1->name))->toBeLessThan(strpos($content, $author2->name));
});

test('show displays author with published articles', function () {
    $author = User::factory()->create();
    $publishedArticle = Article::factory()->create([
        'author_id' => $author->id,
        'is_published' => true,
    ]);
    $unpublishedArticle = Article::factory()->create([
        'author_id' => $author->id,
        'is_published' => false,
    ]);

    $response = $this->get(route('authors.show', $author));

    $response->assertStatus(200);
    $response->assertSeeText($author->name);
    $response->assertSeeText($publishedArticle->title);
    $response->assertDontSeeText($unpublishedArticle->title);
});
