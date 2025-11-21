<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

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
            'title' => fake()->sentence(8),
            'content' => fake()->paragraph(5),
            'author_id' => fake()->numberBetween(1,5),
            'is_published' => fake()->boolean(80),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Article $article) {
            $imagesPath = storage_path('seeding/articles');
            $images = File::files($imagesPath);

            if (count($images) > 0) {
                // Pick a random image using array_rand for each article
                $randomImage = $images[array_rand($images)];

                $article->addMedia($randomImage->getPathname())
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        });
    }


}
