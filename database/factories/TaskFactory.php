<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Task::class, function (Faker $faker) {
    $started = now();
    $finished = now()->addDays(3);
    return [
        'title' => $faker->company,
        'description' => $faker->text,
        'status' => 'nova',
        'started_at' => $started,
        'finished_at' => $finished,
        'user_id' => function() {
            return factory(\App\User::class)->create()->id;
        }
    ];
});

$factory->state(\App\Task::class, 'nova', [
    'status' => 'nova'
]);
$factory->state(\App\Task::class, 'em_andamento', [
    'status' => 'em_andamento'
]);
$factory->state(\App\Task::class, 'em_testes', [
    'status' => 'em_testes'
]);
$factory->state(\App\Task::class, 'finalizada', [
    'status' => 'finalizada'
]);
