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
        $share = $this->uniqueUrlShare();

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

    private function uniqueUrlShare()
    {
        $is_task_share = true;
        While($is_task_share === true) {
            $unique_url = Str::random(20);
            $is_task_share = Task::where('share', $unique_url)->exists();
        }
        return $unique_url;
    }
}
