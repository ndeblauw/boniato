<?php

use App\Models\User;
use App\Models\Article;
use App\Jobs\InformAdminsOfNewPublicationJob;
use Illuminate\Support\Facades\Queue;

it('toggles article is_published from false to true', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['is_published' => false]);

    $response = $this->actingAs($user)->post("/admin/articles/{$article->id}/toggle-published");

    $response->assertRedirect();
    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'is_published' => true,
    ]);
});

it('toggles article is_published from true to false', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['is_published' => true]);

    $response = $this->actingAs($user)->post("/admin/articles/{$article->id}/toggle-published");

    $response->assertRedirect();
    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'is_published' => false,
    ]);
});

it('dispatches InformAdminsOfNewPublicationJob when publishing', function () {
    Queue::fake();
    $user = User::factory()->create();
    $article = Article::factory()->create(['is_published' => false]);

    $this->actingAs($user)->post("/admin/articles/{$article->id}/toggle-published");

    Queue::assertPushed(InformAdminsOfNewPublicationJob::class, function ($job) use ($article, $user) {
        return $job->article->id === $article->id && $job->user->id === $user->id;
    });
});

it('does not dispatch InformAdminsOfNewPublicationJob when unpublishing', function () {
    Queue::fake();
    $user = User::factory()->create();
    $article = Article::factory()->create(['is_published' => true]);

    $this->actingAs($user)->post("/admin/articles/{$article->id}/toggle-published");

    Queue::assertNotPushed(InformAdminsOfNewPublicationJob::class);
});

it('handles non-existent article id', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/admin/articles/999/toggle-published');

    expect($response->getStatusCode())->toBe(500);
});

it('handles article id as string', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['is_published' => false]);

    $response = $this->actingAs($user)->post("/admin/articles/" . $article->id . "/toggle-published");

    $response->assertRedirect();
    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'is_published' => true,
    ]);
});

it('redirects back after toggling', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['is_published' => false]);

    $response = $this->actingAs($user)->post("/admin/articles/{$article->id}/toggle-published");

    $response->assertRedirect();
});

it('handles article with existing published status', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['is_published' => true]);

    $this->actingAs($user)->post("/admin/articles/{$article->id}/toggle-published");

    $this->actingAs($user)->post("/admin/articles/{$article->id}/toggle-published");

    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'is_published' => true,
    ]);
});