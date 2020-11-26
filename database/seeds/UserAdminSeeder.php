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
            'name' => 'Admin User',
            'email' => 'admin@user.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123456')
        ]);
    }
}
