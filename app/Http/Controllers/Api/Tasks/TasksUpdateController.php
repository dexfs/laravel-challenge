<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Task;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class TasksUpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $data = array_merge($request->all(), ['id' => $id]);

        $this->validator($data)->validate();
        $task = Task::findOrFail($id);
        $task->fill($request->all());
        $task->save();

        return $request->wantsJson()
            ? response('', 200)
            : response('', 400);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => ['required'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string', 'max:255'],
            'status' => ['sometimes', 'required', 'string'],
            'started_at' => ['sometimes', 'sometimes', 'date'],
            'finished_at' => ['sometimes', 'sometimes', 'date'],
        ]);
    }

}
