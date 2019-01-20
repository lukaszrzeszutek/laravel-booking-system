<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(ObiektsTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(LikeablesTableSeeder::class);
        $this->call(PhotosTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
        $this->call(ReservationsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);

    }
}
