<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = fake()->sentence(8),
            'slug' => Str::slug($title),
            'content' => fake()->paragraph(5),
            'author_id' => fake()->numberBetween(1,5),
            'deleted_at' => fake()->boolean(80) ? null : fake()->datetime(),
            'is_published' => fake()->boolean(80),
        ];
    }
}
