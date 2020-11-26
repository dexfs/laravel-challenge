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
         if( in_array(app()->environment(), ['local', 'development'])) {
            $this->call(UsersTableSeeder::class);
            $this->call(UserAdminSeeder::class);
         }
    }
}
