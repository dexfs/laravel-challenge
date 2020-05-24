<?php


namespace App\Http\Controllers\Tasks;


use App\Http\Controllers\Controller;
use App\Task;


class IndexController extends Controller
{

    public function index(Task $task)
    {
        return view('tasks.index');
    }
}
