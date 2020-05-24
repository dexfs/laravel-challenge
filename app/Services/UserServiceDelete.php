<?php


namespace App\Services;


use App\Task;
use App\User;

class UserServiceDelete
{
    /**
     * @var \App\User
     */
    private $user;
    /**
     * @var \App\Task
     */
    private $task;

    public function __construct(User $user, Task $task)
    {
        $this->user = $user;
        $this->task = $task;
    }

    public function __invoke($id)
    {
        try {
            $user = $this->user->with('tasks')->where('id', $id)->first();
            $user->tasks()->delete();
            $user->delete();
        }
        catch (\Exception $e) {
            throw new $e;
        }
    }


}
