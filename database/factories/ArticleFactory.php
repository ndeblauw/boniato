<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'title' => fake()->realTextBetween(20, 50),
            'content' => fake()->paragraph(5),
            'author_id' => fake()->numberBetween(1,5),
            'deleted_at' => fake()->boolean(80) ? null : fake()->datetime(),
            'is_published' => fake()->boolean(80),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Article $article) {
            return $article;
        });
    }

    // Solution from https://laracasts.com/discuss/channels/testing/how-to-disable-factory-callbacks
    public function withImages(): self
    {
        return $this->afterCreating(function (Article $article) {
            $url = 'https://loremflickr.com/320/240';
            $article
                ->addMediaFromUrl($url)
                ->toMediaCollection();
        });
    }
}
