<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUsersList()
    {
        factory(\App\User::class, 10)->create();
        $response = $this->withHeaders(
            ['Accept' => 'application/json']
        )->json('GET', '/api/users');
        $data = $response->decodeResponseJson();
        $response->assertSuccessful();
        self::assertCount(10, $data['data']);
    }

    public function testUserCreate()
    {
        $user = factory(\App\User::class)->make();
        $response = $this->withHeaders(
            ['Accept' => 'application/json']
        )->json('POST', '/api/users', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make('123456789')
        ] );
        $response->assertCreated();
    }

    public function testUserCreateFail()
    {
        $user = factory(\App\User::class)->make();
        $response = $this->withHeaders(
            ['Accept' => 'application/json']
        )->json('POST', '/api/users', [
            'name' => $user->name,
            'email' => $user->email,
        ] );
        $response->assertStatus(422);
    }

    public function testUserUpdate()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->withHeaders(
            ['Accept' => 'application/json']
        )->json('PUT', "/api/users/$user->id", [
            'name' => 'Updated Name',
        ] );

        $response->assertStatus(200);
    }
    public function testUserUpdateWithNoValidId()
    {
        $response = $this->withHeaders(
            ['Accept' => 'application/json']
        )->json('PUT', "/api/users/0");

        $response->assertStatus(404);
    }

    public function testUserDelete()
    {
        $user = factory(\App\User::class, 1)->create()
            ->each(function ($user){
                $tasks = factory(\App\Task::class, 2)->state('finalizada')->make([
                    'user_id' => $user->id,
                ]);
                $user->tasks()->saveMany($tasks);
            })->first();

        $response = $this->withHeaders(
            ['Accept' => 'application/json']
        )->json('DELETE', "/api/users/$user->id");

        $response->assertStatus(204);
    }

    public function testUserDeleteFail()
    {
        $response = $this->withHeaders(
            ['Accept' => 'application/json']
        )->json('DELETE', "/api/users/0");

        $response->assertStatus(404);
    }
}
