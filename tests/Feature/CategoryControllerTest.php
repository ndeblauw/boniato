<?php

use App\Models\Category;
use App\Models\User;

test('index displays all categories', function () {
    $categories = Category::factory()->count(3)->create();

    $response = $this->get(route('categories.index'));

    $response->assertStatus(200);
    foreach ($categories as $category) {
        $response->assertSeeText($category->name);
    }
});

test('show displays specific category', function () {
    $category = Category::factory()->create();

    $response = $this->get(route('categories.show', $category->id));

    $response->assertStatus(200);
    $response->assertSeeText($category->name);
});
