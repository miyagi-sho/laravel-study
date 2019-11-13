<?php

namespace App\Business\Task;

use App\Folder;
use App\Task;
use Illuminate\Support\Str;
use Storage;

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



    public function create($folder, $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->memo = $request->memo;

        if($request->has('image')) {
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('task_image', $image, 'public');
            $task->image_path = Storage::disk('s3')->url($path);
        }
        $folder->tasks()->save($task);
    }

    public function edit($folder, $task, $request)
    {
        $this->checkRelation($folder, $task);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->memo = $request->memo;

        if($request->has('image')) {
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('task_image', $image, 'public');
            $task->image_path = Storage::disk('s3')->url($path);
        }
        $task->save();
    }

    /**
     * @param $task
     */
    public function randomShare($task)
    {
        $share = $this->createUniqueUrlShare();

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

    private function checkRelation(Folder $folder, Task $task)
    {
        if($folder->id !== $task->folder_id) {
            abort(404);
        }
    }

    private function createUniqueUrlShare()
    {
        $is_task_share = true;
        While($is_task_share === true) {
            $unique_url = Str::random(20);
            $is_task_share = Task::where('share', $unique_url)->exists();
        }
        return $unique_url;
    }
}
