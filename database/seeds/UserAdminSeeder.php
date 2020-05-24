<?php

use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'name' => 'Admin DotSe',
            'email' => 'admin@dotse.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123456')
        ]);
    }
}
