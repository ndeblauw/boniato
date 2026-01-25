<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->admin = User::factory()->create(['is_admin' => true]);
});

test('index shows only own articles for regular user', function () {
    $ownArticle = Article::factory()->create(['author_id' => $this->user->id]);
    $otherArticle = Article::factory()->create();

    $response = $this->actingAs($this->user)->get(route('admin.articles.index'));

    $response->assertStatus(200);
    $response->assertSeeText($ownArticle->title);
    $response->assertDontSeeText($otherArticle->title);
});

test('index shows all articles for admin', function () {
    $article1 = Article::factory()->create(['author_id' => $this->user->id]);
    $article2 = Article::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('admin.articles.index'));

    $response->assertStatus(200);
    $response->assertSeeText($article1->title);
    $response->assertSeeText($article2->title);
});

test('create shows article creation form', function () {
    $response = $this->actingAs($this->user)->get(route('admin.articles.create'));

    $response->assertStatus(200);
});

test('store creates new article', function () {
    $response = $this->actingAs($this->user)->post(route('admin.articles.store'), [
        'title' => 'Test Article Title Here',
        'slug' => 'test-article-slug',
        'content' => 'This is test content with sufficient length',
    ]);

    $response->assertRedirect('/admin/articles');
    $this->assertDatabaseHas('articles', [
        'title' => 'Test Article Title Here',
        'slug' => 'test-article-slug',
    ]);
});

test('store validates title requirements', function () {
    $response = $this->actingAs($this->user)->post(route('admin.articles.store'), [
        'title' => 'short',
    ]);

    $response->assertSessionHasErrors(['title']);
});

test('store syncs categories', function () {
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();

    $this->actingAs($this->user)->post(route('admin.articles.store'), [
        'title' => 'Test Article With Categories',
        'content' => 'This is test content with sufficient length',
        'categories' => [$category1->id, $category2->id],
    ]);

    $article = Article::where('title', 'Test Article With Categories')->first();
    expect($article)->not->toBeNull();
    $article->load('categories');
    expect($article->categories)->toHaveCount(2);
});

test('store clears welcome page cache', function () {
    cache()->put('welcome_page_articles', 'test', 60);

    $this->actingAs($this->user)->post(route('admin.articles.store'), [
        'title' => 'Cache Clear Test Article',
        'content' => 'This is test content with sufficient length',
    ]);

    expect(cache()->has('welcome_page_articles'))->toBeFalse();
});

test('show displays article', function () {
    $article = Article::factory()->create(['author_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('admin.articles.show', $article));

    $response->assertStatus(200);
    $response->assertSeeText($article->title);
});

test('edit shows article edit form for owner', function () {
    $article = Article::factory()->create(['author_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->get(route('admin.articles.edit', $article));

    $response->assertStatus(200);
});

test('edit shows article edit form for admin', function () {
    $article = Article::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('admin.articles.edit', $article));

    $response->assertStatus(200);
});

test('edit denies access for non-owner non-admin', function () {
    $article = Article::factory()->create();

    $response = $this->actingAs($this->user)->get(route('admin.articles.edit', $article));

    $response->assertStatus(403);
});

test('update modifies article for owner', function () {
    $article = Article::factory()->create(['author_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->put(route('admin.articles.update', $article), [
        'title' => 'Updated Article Title Here',
        'content' => 'Updated content with sufficient length here',
    ]);

    $response->assertRedirect('/admin/articles');
    $this->assertDatabaseHas('articles', [
        'id' => $article->id,
        'title' => 'Updated Article Title Here',
    ]);
});

test('update denies access for non-owner non-admin', function () {
    $article = Article::factory()->create();

    $response = $this->actingAs($this->user)->put(route('admin.articles.update', $article), [
        'title' => 'Updated Article Title Here',
    ]);

    $response->assertStatus(403);
});

test('update syncs categories', function () {
    $article = Article::factory()->create(['author_id' => $this->user->id]);
    $category = Category::factory()->create();

    $this->actingAs($this->user)->put(route('admin.articles.update', $article), [
        'title' => 'Updated With Categories Title',
        'content' => 'Updated content with sufficient length',
        'categories' => [$category->id],
    ]);

    $article->refresh();
    $article->load('categories');
    expect($article->categories)->toHaveCount(1);
});

test('update clears welcome page cache', function () {
    $article = Article::factory()->create(['author_id' => $this->user->id]);
    cache()->put('welcome_page_articles', 'test', 60);

    $this->actingAs($this->user)->put(route('admin.articles.update', $article), [
        'title' => 'Cache Clear Updated Title',
        'content' => 'Updated content with sufficient length',
    ]);

    expect(cache()->has('welcome_page_articles'))->toBeFalse();
});

test('destroy deletes article for owner', function () {
    $article = Article::factory()->create(['author_id' => $this->user->id]);

    $response = $this->actingAs($this->user)->delete(route('admin.articles.destroy', $article));

    $response->assertRedirect('/admin/articles');
    $this->assertSoftDeleted('articles', ['id' => $article->id]);
});

test('destroy denies access for non-owner non-admin', function () {
    $article = Article::factory()->create();

    $response = $this->actingAs($this->user)->delete(route('admin.articles.destroy', $article));

    $response->assertStatus(403);
});

test('destroy clears welcome page cache', function () {
    $article = Article::factory()->create(['author_id' => $this->user->id]);
    cache()->put('welcome_page_articles', 'test', 60);

    $this->actingAs($this->user)->delete(route('admin.articles.destroy', $article));

    expect(cache()->has('welcome_page_articles'))->toBeFalse();
});
