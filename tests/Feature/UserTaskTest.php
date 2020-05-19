<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTasksList()
    {
        factory(Task::class)->create();
        $response = $this->withHeaders(
            ['Accept' => 'application/json']
        )->json('GET', '/api/tasks');

        $response->assertSuccessful()->assertJsonCount(1, 'data');
    }

    public function testTaskCreate()
    {
        $user = factory(User::class)->create();
        $task = factory(\App\Task::class)->make([
            'user_id' => $user->id
        ]);

        $response = $this->withHeaders(
            ['Accept' => 'application/json']
        )->json('POST', '/api/tasks', $task->toArray());

        $response->assertCreated();
    }
    public function testTaskUpdate()
    {
        $user = factory(User::class)->create();
        $task = factory(\App\Task::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->json('PUT', "/api/tasks/$task->id", [
            'title' => 'Title Updated Task',
        ]);
        $response->assertOk();
        self::assertEquals('Title Updated Task', $task->refresh()->title);
    }

    public function testTaskDelete()
    {
        $user = factory(User::class)->create();
        $task = factory(\App\Task::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->json('DELETE', "/api/tasks/$task->id");
        $response->assertOk();
        self::assertDatabaseMissing('user_tasks', $task->toArray());
    }

    public function testTaskSaveTotalElapsedTime()
    {
        Carbon::setTestNow('2020-05-17 09:30:00');
        $user = factory(User::class)->create();
        $task = factory(\App\Task::class)->create([
            'user_id' => $user->id,
            'started_at' => Carbon::now(),
            'finished_at'=> Carbon::now()->addDays(1)->setSeconds(22)->addHours(8)
        ]);
        $response = $this->json('POST', '/api/tasks', $task->toArray());
        $response->assertCreated();
        self::assertEquals('32:00:22', $response->decodeResponseJson('data')['total_elapsed_time']);
    }


}
