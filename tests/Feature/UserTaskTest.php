<?php

namespace Tests\Feature;

use App\Task;
use App\User;
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


}
