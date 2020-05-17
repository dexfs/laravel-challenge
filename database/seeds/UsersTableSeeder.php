<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 10)->create()
            ->each(function ($user){
                $user->tasks()->save(factory(\App\Task::class)->make());
            });
        factory(\App\User::class)->create([
            'email' => 'a@a.com'
        ]);
    }
}
