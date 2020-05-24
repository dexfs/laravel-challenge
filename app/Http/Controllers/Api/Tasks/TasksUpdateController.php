<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Services\TaskServiceUpdate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TasksUpdateController extends Controller
{
    /**
     * @var \App\Services\TaskServiceUpdate
     */
    private $serviceUpdate;

    public function __construct(TaskServiceUpdate $serviceUpdate)
    {
        $this->serviceUpdate = $serviceUpdate;
    }

    public function __invoke(Request $request, $id)
    {
        $data = array_merge($request->all(), ['id' => $id]);

        $this->validator($data)->validate();
        $result = $this->serviceUpdate->__invoke($data, $id);

        return $request->wantsJson()
            ? response(['data' => $result], 200)
            : response('', 400);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => ['required'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string', 'max:255'],
            'status' => ['sometimes', 'required', 'string'],
            'started_at' => ['sometimes', 'date'],
            'finished_at' => ['sometimes', 'date'],
        ]);
    }

}
