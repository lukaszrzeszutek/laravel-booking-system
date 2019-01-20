<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create('pl_PL');

      for($i=1;$i<=10;$i++)
      {
        DB::table('cities')->insert([
          'name' => $faker->unique()->city

        ]);
      }
    }
}
