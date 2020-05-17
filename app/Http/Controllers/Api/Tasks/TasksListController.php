<?php


namespace App\Http\Controllers\Api\Tasks;
use App\Task;
use App\User;
use App\Http\Controllers\Controller;


class TasksListController extends Controller
{
    public function __invoke()
    {
        $tasks = Task::paginate();
        return response()->json($tasks);
    }

}
