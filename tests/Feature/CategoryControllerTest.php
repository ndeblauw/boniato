<?php

use App\Models\Category;

it('displays all categories on index', function () {
    $categories = Category::factory()->count(5)->create();

    $response = $this->get('/categories');

    $response->assertSuccessful()
        ->assertViewIs('categories.index')
        ->assertViewHas('categories')
        ->assertViewHas('categories', function ($viewCategories) use ($categories) {
            return $viewCategories->count() === $categories->count();
        });
});

it('displays empty categories page when no categories exist', function () {
    $response = $this->get('/categories');

    $response->assertSuccessful()
        ->assertViewIs('categories.index')
        ->assertViewHas('categories');
});

it('displays single category by id', function () {
    $category = Category::factory()->create();

    $response = $this->get("/categories/{$category->id}");

    $response->assertSuccessful()
        ->assertViewIs('categories.show')
        ->assertViewHas('category', $category);
});

it('handles non-existent category id', function () {
    $response = $this->get('/categories/999');

    $response->assertSuccessful()
        ->assertViewIs('categories.show')
        ->assertViewHas('category', null);
});

it('handles category id as string', function () {
    $category = Category::factory()->create();

    $response = $this->get("/categories/" . $category->id);

    $response->assertSuccessful()
        ->assertViewHas('category', $category);
});

it('handles category id zero', function () {
    $response = $this->get('/categories/0');

    $response->assertSuccessful()
        ->assertViewIs('categories.show')
        ->assertViewHas('category', null);
});

it('handles negative category id', function () {
    $response = $this->get('/categories/-1');

    $response->assertSuccessful()
        ->assertViewIs('categories.show')
        ->assertViewHas('category', null);
});