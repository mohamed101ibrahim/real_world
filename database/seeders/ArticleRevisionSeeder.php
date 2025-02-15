<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\User;
use Faker\Factory as Faker;

class ArticleRevisionSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $articles = Article::all();

        foreach ($articles as $article) {
            $user = $article->user ?? User::inRandomOrder()->first(); 
            for ($i = 0; $i < rand(2, 5); $i++) {
                ArticleRevision::create([
                    'article_id'  => $article->id,
                    'user_id'     => $user->id,
                    'title'       => $faker->sentence,
                    'description' => $faker->paragraph,
                    'body'        => $faker->text(1000),
                    'created_at'  => now()->subDays(rand(1, 30)),
                    'updated_at'  => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}