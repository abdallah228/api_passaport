<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Article;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = \Faker\Factory::create();
        for($i = 1; $i <= 15; $i++)
        {
            Article::create([
                'user_id'=>User::inRandomOrder()->first()->id,
                'title'=>$faker->sentence(4),
                'body'=>$faker->paragraph(),

            ]);
        }
    }
}
