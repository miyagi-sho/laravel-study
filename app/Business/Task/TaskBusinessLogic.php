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
        $data = true;
        While($data === true) {
            $share = Str::random(20);
            $data = Task::where('share', $share)->exists();
        }

        $task->share = $share;
        $task->save();
    }

    /**
     * @param $share
     * @return mixed
     */
    public function searchTask($share){
        return Task::where('share', $share)->first();
    }
}
