<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

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
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
        User::factory(5)->create();

        Category::create(['name' => 'Burgers']);
        Category::create(['name' => 'Pizza']);
        Category::create(['name' => 'Salads']);
        Category::factory(5)->create();
        $articles = Article::factory(10)->create();

        // Associate articles with Categories
        $articles->each(function ($article) {
            $nr_categories = random_int(0,3);
            $category_list = [];
            for ($i = 0; $i < $nr_categories; $i++) {
                $category_list[] = random_int(1,7);
            }
            $article->categories()->attach($category_list);
        });

        Comment::factory(40)->create();
    }
}
