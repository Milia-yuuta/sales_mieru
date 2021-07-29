<?php

use Database\Seeders\ClientsTableSeeder;
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
        $this->call([
            AdminTableSeeder::class,
            UserTableSeeder::class,
            PropertyMasterTableSeeder::class,
            UserMasterTableSeeder::class,
            ActionMasterTableSeeder::class,
            PropertyTableSeeder::class,
            PrefectureMasterTableSeeder::class,
            TeamTableSeeder::class,
            ClientsTableSeeder::class,
        ]);
    }
}
