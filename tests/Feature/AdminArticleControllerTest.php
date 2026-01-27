<?php

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('displays admin articles index for regular user', function () {
    $user = User::factory()->create(['is_admin' => false]);
    $userArticles = Article::factory()->count(3)->create(['author_id' => $user->id]);
    $otherArticles = Article::factory()->count(2)->create();

    $response = $this->actingAs($user)->get('/admin/articles');

    $response->assertSuccessful()
        ->assertViewIs('admin.articles.index')
        ->assertViewHas('articles');
    
    $articles = $response->viewData('articles');
    expect($articles)->toHaveCount(3);
    expect($articles->pluck('id'))->toContain($userArticles->pluck('id')->toArray());
});

it('displays admin articles index for admin user', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $allArticles = Article::factory()->count(5)->create();

    $response = $this->actingAs($admin)->get('/admin/articles');

    $response->assertSuccessful()
        ->assertViewIs('admin.articles.index')
        ->assertViewHas('articles');
    
    $articles = $response->viewData('articles');
    expect($articles)->toHaveCount(5);
});

it('displays create article form', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/admin/articles/create');

    $response->assertSuccessful()
        ->assertViewIs('admin.articles.create');
});

it('creates article with valid data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/admin/articles', [
        'title' => 'Valid article title with enough characters',
        'slug' => 'valid-article-slug',
        'content' => 'Valid article content with enough characters',
    ]);

    $response->assertRedirect('/admin/articles');
    $this->assertDatabaseHas('articles', [
        'title' => 'Valid article title with enough characters',
        'slug' => 'valid-article-slug',
        'content' => 'Valid article content with enough characters',
        'author_id' => 1,
    ]);
});

it('creates article with categories', function () {
    $user = User::factory()->create();
    $categories = Category::factory()->count(2)->create();

    $response = $this->actingAs($user)->post('/admin/articles', [
        'title' => 'Valid article title with enough characters',
        'slug' => 'valid-article-slug',
        'content' => 'Valid article content with enough characters',
        'categories' => $categories->pluck('id')->toArray(),
    ]);

    $response->assertRedirect('/admin/articles');
    $this->assertDatabaseHas('articles', [
        'title' => 'Valid article title with enough characters',
    ]);
    
    $article = Article::where('title', 'Valid article title with enough characters')->first();
    expect($article->categories)->toHaveCount(2);
});

it('creates article without categories', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/admin/articles', [
        'title' => 'Valid article title with enough characters',
        'slug' => 'valid-article-slug',
        'content' => 'Valid article content with enough characters',
    ]);

    $response->assertRedirect('/admin/articles');
    
    $article = Article::where('title', 'Valid article title with enough characters')->first();
    expect($article->categories)->toHaveCount(0);
});

it('validates article creation fields', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/admin/articles', [
        'title' => 'Too short',
        'slug' => 'short',
        'content' => 'short',
    ]);

    $response->assertSessionHasErrors(['title', 'slug', 'content']);
});

it('clears cache after article creation', function () {
    $user = User::factory()->create();
    cache()->put('welcome_page_articles', 'test');

    $this->actingAs($user)->post('/admin/articles', [
        'title' => 'Valid article title with enough characters',
        'slug' => 'valid-article-slug',
        'content' => 'Valid article content with enough characters',
    ]);

    expect(cache()->has('welcome_page_articles'))->toBeFalse();
});

it('displays single article', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();

    $response = $this->actingAs($user)->get("/admin/articles/{$article->id}");

    $response->assertSuccessful()
        ->assertViewIs('admin.articles.show')
        ->assertViewHas('article', $article);
});

it('displays edit article form for owner', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $user->id]);

    $response = $this->actingAs($user)->get("/admin/articles/{$article->id}/edit");

    $response->assertSuccessful()
        ->assertViewIs('admin.articles.edit')
        ->assertViewHas('article', $article);
});

it('displays edit article form for admin', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $article = Article::factory()->create();

    $response = $this->actingAs($admin)->get("/admin/articles/{$article->id}/edit");

    $response->assertSuccessful()
        ->assertViewIs('admin.articles.edit')
        ->assertViewHas('article', $article);
});

it('forbids edit article for non-owner', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $otherUser->id]);

    $response = $this->actingAs($user)->get("/admin/articles/{$article->id}/edit");

    $response->assertForbidden();
});

it('updates article for owner', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $user->id]);

    $response = $this->actingAs($user)->put("/admin/articles/{$article->id}", [
        'title' => 'Updated article title with enough characters',
        'slug' => 'updated-article-slug',
        'content' => 'Updated article content with enough characters',
    ]);

    $response->assertRedirect('/admin/articles');
    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'title' => 'Updated article title with enough characters',
        'slug' => 'updated-article-slug',
        'content' => 'Updated article content with enough characters',
    ]);
});

it('updates article for admin', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $article = Article::factory()->create();

    $response = $this->actingAs($admin)->put("/admin/articles/{$article->id}", [
        'title' => 'Updated article title with enough characters',
        'slug' => 'updated-article-slug',
        'content' => 'Updated article content with enough characters',
    ]);

    $response->assertRedirect('/admin/articles');
    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'title' => 'Updated article title with enough characters',
    ]);
});

it('forbids update article for non-owner', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $otherUser->id]);

    $response = $this->actingAs($user)->put("/admin/articles/{$article->id}", [
        'title' => 'Updated article title with enough characters',
        'slug' => 'updated-article-slug',
        'content' => 'Updated article content with enough characters',
    ]);

    $response->assertForbidden();
});

it('updates article with photo', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $user->id]);
    $file = UploadedFile::fake()->image('photo.jpg');

    $response = $this->actingAs($user)->put("/admin/articles/{$article->id}", [
        'title' => 'Updated article title with enough characters',
        'slug' => 'updated-article-slug',
        'content' => 'Updated article content with enough characters',
        'photo' => $file,
    ]);

    $response->assertRedirect('/admin/articles');
    $article->refresh();
    expect($article->getMedia())->toHaveCount(1);
});

it('updates article with new author', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $newAuthor = User::factory()->create();
    $article = Article::factory()->create();

    $response = $this->actingAs($admin)->put("/admin/articles/{$article->id}", [
        'title' => 'Updated article title with enough characters',
        'slug' => 'updated-article-slug',
        'content' => 'Updated article content with enough characters',
        'author_id' => $newAuthor->id,
    ]);

    $response->assertRedirect('/admin/articles');
    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'author_id' => $newAuthor->id,
    ]);
});

it('clears cache after article update', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $user->id]);
    cache()->put('welcome_page_articles', 'test');

    $this->actingAs($user)->put("/admin/articles/{$article->id}", [
        'title' => 'Updated article title with enough characters',
        'slug' => 'updated-article-slug',
        'content' => 'Updated article content with enough characters',
    ]);

    expect(cache()->has('welcome_page_articles'))->toBeFalse();
});

it('deletes article for owner', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $user->id]);

    $response = $this->actingAs($user)->delete("/admin/articles/{$article->id}");

    $response->assertRedirect('/admin/articles');
    $this->assertDatabaseMissing('articles', ['id' => $article->id]);
});

it('deletes article for admin', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $article = Article::factory()->create();

    $response = $this->actingAs($admin)->delete("/admin/articles/{$article->id}");

    $response->assertRedirect('/admin/articles');
    $this->assertDatabaseMissing('articles', ['id' => $article->id]);
});

it('forbids delete article for non-owner', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $otherUser->id]);

    $response = $this->actingAs($user)->delete("/admin/articles/{$article->id}");

    $response->assertForbidden();
    $this->assertDatabaseHas('articles', ['id' => $article->id]);
});

it('clears cache after article deletion', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['author_id' => $user->id]);
    cache()->put('welcome_page_articles', 'test');

    $this->actingAs($user)->delete("/admin/articles/{$article->id}");

    expect(cache()->has('welcome_page_articles'))->toBeFalse();
});