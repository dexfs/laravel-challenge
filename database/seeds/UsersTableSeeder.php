<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\App\User::class)->create()
            ->each(function ($user){
                $tasks = factory(\App\Task::class, 1)->state('nova')->make([
                    'finished_at' => null,
                    'user_id' => $user->id
                ]);
                $user->tasks()->saveMany($tasks);
            });
        factory(\App\User::class, 1)->create()
            ->each(function ($user){
                $tasks = factory(\App\Task::class, 4)->state('em_andamento')->make([
                    'user_id' => $user->id
                ]);
                $user->tasks()->saveMany($tasks);
            });
        factory(\App\User::class, 1)->create()
            ->each(function ($user){
                $tasks = factory(\App\Task::class, 1)->state('em_testes')->make([
                    'user_id' => $user->id
                ]);
                $user->tasks()->saveMany($tasks);
            });
        factory(\App\User::class, 1)->create()
            ->each(function ($user){
                $tasks = factory(\App\Task::class, 5)->state('finalizada')->make([
                    'user_id' => $user->id
                ]);
                $user->tasks()->saveMany($tasks);
            });
        // fora do mês corrent
        $started = now()->addMonths(1);
        $finished = now()->addMonths(1)->addDays(3);

        factory(\App\User::class, 1)->create()
            ->each(function ($user) use($started, $finished){
                $tasks = factory(\App\Task::class, 1)->state('finalizada')->make([
                    'user_id' => $user->id,
                    'started_at' => $started,
                    'finished_at' => $finished,
                ]);
                $user->tasks()->saveMany($tasks);
            });

        factory(\App\User::class)->create([
            'email' => 'a@a.com'
        ]);
    }
}
