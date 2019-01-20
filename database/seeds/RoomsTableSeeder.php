<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
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
        DB::table('rooms')->insert([
          'room_number' => $faker->unique()->numberBetween(1, 30),
          'room_size' => $faker->numberBetween(1, 5),
          'price' => $faker->numberBetween(100, 600),
          'description' => $faker->text(1000),
          'obiekt_id' => $faker->numberBetween(1, 10)

        ]);
      }
    }
}
