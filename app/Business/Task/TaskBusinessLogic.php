<?php

namespace App\Business\Task;

use App\Folder;
use App\Task;
use Exception;
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

    /**
     * @param Folder $folder
     * @param \App\Http\Requests\CreateTask $request
     * @return mixed|void
     */
    public function create($folder, $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->memo = $request->memo;

        $task->image_path = $this->uploadImage($request);

        $folder->tasks()->save($task);
    }

    /**
     * @param Task $task
     * @param \App\Http\Requests\EditTask $request
     * @return mixed|void
     */
    public function edit($task, $request)
    {
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->memo = $request->memo;

        #元々保存されている画像データを削除
        $this->deleteImage($task, $request);

        $task->image_path = $this->uploadImage($request);

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
    public function searchTaskByShare($share)
    {
        return Task::where('share', $share)->first();
    }

    /**
     * @param $folder
     * @param $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function faildCreateImage($folder, $task)
    {
        try {
            if ($task->image_path === "") {
                throw new Exception();
            }
        } catch (Exception $e)  {
            return redirect()->route('tasks.create', [
                'id' => $folder->id,
            ])->withErrors('画像のアップロードに失敗しました。');
        }
    }

    public function faildEditImage($task)
    {
        try {
            if ($task->image_path === "") {
                throw new Exception();
            }
        } catch (Exception $e) {
            return redirect()->route('tasks.edit', [
                'id' => $task->folder_id,
                'task_id' => $task->id,
            ])->withErrors('画像のアップロードに失敗しました。');
        }
    }

    private function uploadImage($request)
    {
        if ($request->has('image')) {
            $image = $request->file('image');
            $image = Storage::disk('s3')->putFile('task_image', $image, 'public');
        }
        return $image;
    }

    private function deleteImage($task, $request)
    {
        if ($request->has('image') &&
            Storage::disk('s3')->exists($task->image_path)
        ) {
            Storage::disk('s3')->delete($task->image_path);
        }
    }

    private function createUniqueUrlShare()
    {
        $is_task_share = true;
        While ($is_task_share === true) {
            $unique_url = Str::random(20);
            $is_task_share = Task::where('share', $unique_url)->exists();
        }
        return $unique_url;
    }
}
