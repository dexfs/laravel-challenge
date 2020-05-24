<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskDashboardTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        factory(\App\User::class)->create()
            ->each(function ($user) {
                $tasks = factory(\App\Task::class, 1)->state('nova')->make([
                    'user_id' => $user->id,
                ]);
                $user->tasks()->saveMany($tasks);
            });
        factory(\App\User::class, 1)->create()
            ->each(function ($user) {
                $tasks = factory(\App\Task::class, 4)->state('em_andamento')->make([
                    'user_id' => $user->id,
                ]);
                $user->tasks()->saveMany($tasks);
            });

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
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDataChartTasksByStatus()
    {

        $response = $this->json('GET', '/api/dashboard/tasks/status');
        $response->assertOk();
        $response->assertJsonStructure([
                'data' => [
                    [
                        'status', 'total',
                    ],
                    [
                        'status', 'total',
                    ]
                ],
            ]
        );
        $response->assertJson([
            'data' => [
                [
                    'status' => 'em_andamento', 'total' => '4',
                ],
                [
                    'status' => 'nova', 'total' => '1',
                ]
            ],
        ]);
    }
    public function testDataChartTasksByUsers()
    {
        $response = $this->json('GET', '/api/dashboard/tasks/users');
        $response->assertOk();
        $response->assertJsonStructure([
                'data' => [
                    [
                        'total', 'user',
                    ],
                    [
                        'total', 'user',
                    ]
                ],
            ]
        );
        $result = $response->decodeResponseJson();

        self::assertEquals('1', $result['data'][0]['total']);
        self::assertEquals('4', $result['data'][1]['total']);
    }
}
