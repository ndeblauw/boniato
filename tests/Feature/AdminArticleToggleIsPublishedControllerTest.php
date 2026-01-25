<?php

use App\Jobs\InformAdminsOfNewPublicationJob;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('toggles article is_published status from false to true', function () {
    $article = Article::factory()->create([
        'author_id' => $this->user->id,
        'is_published' => false,
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.articles.publish', $article->id));

    $response->assertRedirect();
    $article->refresh();
    expect($article->is_published)->toBeTrue();
});

test('toggles article is_published status from true to false', function () {
    $article = Article::factory()->create([
        'author_id' => $this->user->id,
        'is_published' => true,
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.articles.publish', $article->id));

    $response->assertRedirect();
    $article->refresh();
    expect($article->is_published)->toBeFalse();
});

test('dispatches job when article is published', function () {
    Queue::fake();

    $article = Article::factory()->create([
        'author_id' => $this->user->id,
        'is_published' => false,
    ]);

    $this->actingAs($this->user)->get(route('admin.articles.publish', $article->id));

    Queue::assertPushed(InformAdminsOfNewPublicationJob::class);
});

test('does not dispatch job when article is unpublished', function () {
    Queue::fake();

    $article = Article::factory()->create([
        'author_id' => $this->user->id,
        'is_published' => true,
    ]);

    $this->actingAs($this->user)->get(route('admin.articles.publish', $article->id));

    Queue::assertNotPushed(InformAdminsOfNewPublicationJob::class);
});
