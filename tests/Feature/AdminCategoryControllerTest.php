<?php

use App\Models\Category;

it('displays admin categories index', function () {
    $categories = Category::factory()->count(5)->create();

    $response = $this->get('/admin/categories');

    $response->assertSuccessful()
        ->assertViewIs('admin.categories.index')
        ->assertViewHas('categories')
        ->assertViewHas('categories', function ($viewCategories) use ($categories) {
            return $viewCategories->count() === $categories->count();
        });
});

it('displays empty admin categories index', function () {
    $response = $this->get('/admin/categories');

    $response->assertSuccessful()
        ->assertViewIs('admin.categories.index')
        ->assertViewHas('categories');
});

it('displays single category', function () {
    $category = Category::factory()->create();

    $response = $this->get("/admin/categories/{$category->id}");

    $response->assertSuccessful()
        ->assertViewIs('admin.categories.show')
        ->assertViewHas('category', $category);
});

it('handles non-existent category id in show', function () {
    $response = $this->get('/admin/categories/999');

    $response->assertSuccessful()
        ->assertViewIs('admin.categories.show')
        ->assertViewHas('category', null);
});

it('displays create category form', function () {
    $response = $this->get('/admin/categories/create');

    $response->assertSuccessful()
        ->assertViewIs('admin.categories.create');
});

it('creates category with valid data', function () {
    $response = $this->post('/admin/categories', [
        'name' => 'Valid category name with enough characters',
    ]);

    $response->assertRedirect('/categories');
    $this->assertDatabaseHas('categories', [
        'name' => 'Valid category name with enough characters',
    ]);
});

it('validates category name minimum length', function () {
    $response = $this->post('/admin/categories', [
        'name' => 'short',
    ]);

    $response->assertSessionHasErrors('name');
});

it('validates category name is required', function () {
    $response = $this->post('/admin/categories', []);

    $response->assertSessionHasErrors('name');
});

it('validates category name maximum length', function () {
    $longName = str_repeat('a', 256);

    $response = $this->post('/admin/categories', [
        'name' => $longName,
    ]);

    $response->assertSessionHasErrors('name');
});

it('creates category with edge case valid lengths', function () {
    $minName = str_repeat('a', 5);
    $maxName = str_repeat('a', 255);

    $response1 = $this->post('/admin/categories', [
        'name' => $minName,
    ]);

    $response2 = $this->post('/admin/categories', [
        'name' => $maxName,
    ]);

    $response1->assertRedirect('/categories');
    $response2->assertRedirect('/categories');
    
    $this->assertDatabaseHas('categories', ['name' => $minName]);
    $this->assertDatabaseHas('categories', ['name' => $maxName]);
});

it('displays edit category form', function () {
    $category = Category::factory()->create();

    $response = $this->get("/admin/categories/{$category->id}/edit");

    $response->assertSuccessful()
        ->assertViewIs('admin.categories.edit')
        ->assertViewHas('category', $category);
});

it('handles non-existent category id in edit', function () {
    $response = $this->get('/admin/categories/999/edit');

    $response->assertSuccessful()
        ->assertViewIs('admin.categories.edit')
        ->assertViewHas('category', null);
});

it('updates category with valid data', function () {
    $category = Category::factory()->create();

    $response = $this->put("/admin/categories/{$category->id}", [
        'name' => 'Updated category name with enough characters',
    ]);

    $response->assertRedirect('/categories');
    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated category name with enough characters',
    ]);
});

it('validates category update data', function () {
    $category = Category::factory()->create();

    $response = $this->put("/admin/categories/{$category->id}", [
        'name' => 'short',
    ]);

    $response->assertSessionHasErrors('name');
});

it('handles update of non-existent category', function () {
    $response = $this->put('/admin/categories/999', [
        'name' => 'Updated category name with enough characters',
    ]);

    $response->assertRedirect('/categories');
});

it('deletes category', function () {
    $category = Category::factory()->create();

    $response = $this->delete("/admin/categories/{$category->id}");

    $response->assertRedirect('/categories');
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

it('handles deletion of non-existent category', function () {
    $response = $this->delete('/admin/categories/999');

    $response->assertRedirect('/categories');
});

it('handles category id as string in show', function () {
    $category = Category::factory()->create();

    $response = $this->get("/admin/categories/" . $category->id);

    $response->assertSuccessful()
        ->assertViewHas('category', $category);
});

it('handles category id as string in edit', function () {
    $category = Category::factory()->create();

    $response = $this->get("/admin/categories/" . $category->id . "/edit");

    $response->assertSuccessful()
        ->assertViewHas('category', $category);
});

it('handles category id as string in update', function () {
    $category = Category::factory()->create();

    $response = $this->put("/admin/categories/" . $category->id, [
        'name' => 'Updated category name with enough characters',
    ]);

    $response->assertRedirect('/categories');
    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated category name with enough characters',
    ]);
});

it('handles category id as string in delete', function () {
    $category = Category::factory()->create();

    $response = $this->delete("/admin/categories/" . $category->id);

    $response->assertRedirect('/categories');
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});