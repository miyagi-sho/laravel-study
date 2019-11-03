<?php

namespace App\Business\Task;

use App\Task;
use Illuminate\Support\Str;

class TaskBusinessLogic implements TaskBusinessLogicInterface
{
    protected $task;

    /**
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @param $task
     */
    public function randomShare($task)
    {
        $is_task_share = true;
        While($is_task_share === true) {
            $share = Str::random(20);
            $is_task_share = Task::where('share', $share)->exists();
        }

        $task->share = $share;
        $task->save();
    }

    /**
     * @param $share
     * @return mixed
     */
    public function searchTaskByShare($share){
        return Task::where('share', $share)->first();
    }
}
