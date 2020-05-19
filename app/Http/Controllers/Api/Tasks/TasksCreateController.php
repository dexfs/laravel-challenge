<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Services\TaskServiceCreate;
use App\Task;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class TasksCreateController extends Controller
{
    /**
     * @var \App\Services\TaskServiceCreate
     */
    private $taskServiceCreate;

    public function __construct(TaskServiceCreate $taskServiceCreate)
    {
        $this->taskServiceCreate = $taskServiceCreate;
    }

    public function __invoke(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();

        $task = $this->taskServiceCreate->__invoke($data);

        return $request->wantsJson()
            ? response()->json(['data' => $task], 201)
            : response('', 400);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'started_at' => ['sometimes', 'date'],
            'finished_at' => ['sometimes', 'date'],
        ]);
    }

}
