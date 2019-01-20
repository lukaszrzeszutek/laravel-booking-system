<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
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
        DB::table('role_user')->insert([
          'user_id' => $faker->unique()->numberBetween(1, 10),
          'role_id' => $faker->randomElement([1,2,3])


        ]);
      }
    }
}
