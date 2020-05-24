<?php


namespace App\Services;


use App\Task;
use Carbon\Carbon;

class TaskServiceUpdate
{
    /**
     * @var \App\Task
     */
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function __invoke($data, $id)
    {
        $task = Task::findOrFail($id);
        $task->fill($data);
        $task = $this->totalizeTasks($task);
        $task->save();

        return $task->refresh();
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    private function totalizeTasks($task)
    {
        $started  = $task->started_at;
        $finished = $task->finished_at;

        $task->total_elapsed_time = $finished->diffInHours($started).':'.$finished->diff($started)->format('%I:%S');
        return $task;
    }
}
