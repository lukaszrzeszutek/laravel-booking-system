<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create('pl_PL');

      for($i=1;$i<=30;$i++)
      {
        DB::table('articles')->insert([
          'title' => $faker->text(20),
          'content' => $faker->text(1000),
          'created_at' => $faker->dateTime,
          'user_id' => $faker->numberBetween(1, 10),
          'obiekt_id' => $faker->numberBetween(1, 10)

        ]);
      }
    }
}
