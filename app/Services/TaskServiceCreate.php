<?php


namespace App\Services;

use App\Task;
use Carbon\Carbon;


class TaskServiceCreate
{
    /**
     * @var \App\Task
     */
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function __invoke($data)
    {
        $data = $this->totalizeTasks($data);

        return $this->task->create($data);
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    private function totalizeTasks($data)
    {
        if (!empty($data['started_at']) && !empty($data['finished_at'])) {
            $started                    = Carbon::create($data['started_at']);
            $finished                   = Carbon::create($data['finished_at']);
            $data['total_elapsed_time'] = $finished->diffInHours($started).':'.$finished->diff($started)->format('%I:%S');
        }

        return $data;
    }


}
