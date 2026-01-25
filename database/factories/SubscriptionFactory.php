<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_link = random_int(0, 1);

        return [
            'email' => $user_link ? fake()->unique()->safeEmail() : null,
            'user_id' => $user_link ? null : fake()->numberBetween(1, 10),
            'name' => $user_link ? fake()->unique()->name() : null,
        ];
    }
}
