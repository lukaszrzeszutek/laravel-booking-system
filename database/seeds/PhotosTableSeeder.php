<?php

use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create('pl_PL');

      for($i=1;$i<=100;$i++)
      {
        DB::table('photos')->insert([
          'photoable_type' => 'App\Obiekt',
          'photoable_id' => $faker->numberBetween(1, 10),
          'path' => $faker->imageUrl(800,400,'city')

        ]);
      }

      for($i=1;$i<=200;$i++)
      {
        DB::table('photos')->insert([
          'photoable_type' => 'App\Room',
          'photoable_id' => $faker->numberBetween(1, 10),
          'path' => $faker->imageUrl(800,400,'nightlife')

        ]);
      }

      for($i=1;$i<=10;$i++)
      {
        DB::table('photos')->insert([
          'photoable_type' => 'App\User',
          'photoable_id' => $faker->unique()->numberBetween(1, 10),
          'path' => $faker->imageUrl(275,150,'people')

        ]);
      }
    }
}
