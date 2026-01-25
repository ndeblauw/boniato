<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
        User::create([
            'name' => 'Norman Usermann',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
        User::factory(10)->withImages()->create();

        $categories = ['Burgers', 'Pizza', 'Salads', 'Sandwiches', 'Pasta', 'French Fries', 'Drinks'];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
        $articles = Article::factory(20)->withImages()->create();

        // Associate articles with Categories
        $articles->each(function ($article) {
            $nr_categories = random_int(0, 3);
            $category_list = [];
            for ($i = 0; $i < $nr_categories; $i++) {
                $category_list[] = random_int(1, 7);
            }
            $article->categories()->attach($category_list);
        });

        Comment::factory(40)->create();

        Subscription::factory(20)->create();
    }
}
