<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Task;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class TasksDeleteController extends Controller
{
    public function __invoke($id)
    {
        $this->validator(['id' => $id])->validate();
        $task = Task::findOrFail($id);
        $task->delete();

        return request()->wantsJson()
            ? response('', 200)
            : response('', 400);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => ['required'],
        ]);
    }

}
