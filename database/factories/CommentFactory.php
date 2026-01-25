<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parent = fake()->boolean(80) ? 'article' : 'comment';

        return [
            'content' => fake()->text(),
            'article_id' => ($parent == 'article') ? fake()->numberBetween(1, 10) : null,
            'comment_id' => ($parent == 'comment') ? fake()->numberBetween(1, 20) : null,
        ];
    }
}
