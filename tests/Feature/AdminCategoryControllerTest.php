<?php

use App\Models\Category;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['is_admin' => true]);
});

test('index displays all categories', function () {
    $categories = Category::factory()->count(3)->create();

    $response = $this->actingAs($this->user)->get(route('admin.categories.index'));

    $response->assertStatus(200);
    foreach ($categories as $category) {
        $response->assertSeeText($category->name);
    }
});

test('show displays specific category', function () {
    $category = Category::factory()->create();

    $response = $this->actingAs($this->user)->get(route('admin.categories.show', $category->id));

    $response->assertStatus(200);
    $response->assertSeeText($category->name);
});

test('create shows category creation form', function () {
    $response = $this->actingAs($this->user)->get(route('admin.categories.create'));

    $response->assertStatus(200);
});

test('store creates new category', function () {
    $response = $this->actingAs($this->user)->post(route('admin.categories.store'), [
        'name' => 'New Test Category',
    ]);

    $response->assertRedirect('/categories');
    $this->assertDatabaseHas('categories', [
        'name' => 'New Test Category',
    ]);
});

test('store validates name requirements', function () {
    $response = $this->actingAs($this->user)->post(route('admin.categories.store'), [
        'name' => 'abc',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('edit shows category edit form', function () {
    $category = Category::factory()->create();

    $response = $this->actingAs($this->user)->get(route('admin.categories.edit', $category->id));

    $response->assertStatus(200);
});

test('update modifies category', function () {
    $category = Category::factory()->create();

    $response = $this->actingAs($this->user)->put(route('admin.categories.update', $category->id), [
        'name' => 'Updated Category Name',
    ]);

    $response->assertRedirect('/categories');
    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated Category Name',
    ]);
});

test('update validates name requirements', function () {
    $category = Category::factory()->create();

    $response = $this->actingAs($this->user)->put(route('admin.categories.update', $category->id), [
        'name' => 'abc',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('destroy deletes category', function () {
    $category = Category::factory()->create();

    $response = $this->actingAs($this->user)->delete(route('admin.categories.destroy', $category->id));

    $response->assertRedirect('/categories');
    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});
