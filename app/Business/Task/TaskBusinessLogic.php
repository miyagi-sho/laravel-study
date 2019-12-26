<?php

namespace App\Business\Task;

use App\Folder;
use App\Task;
use App\TaskFullText;
use Exception;
use Illuminate\Support\Facades\Auth;
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
     * @return Task|mixed
     * @throws Exception
     */
    public function create($folder, $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->memo = $request->memo;

        $task->image_path = $this->uploadImage($task, $request);

        if ($task->image_path !== "") {
            $folder->tasks()->save($task);
        }

        return $task;
    }

    /**
     * @param Task $task
     * @param \App\Http\Requests\EditTask $request
     * @return mixed|void
     * @throws Exception
     */
    public function edit($task, $request)
    {
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->memo = $request->memo;

        #元々保存されている画像データを削除
        $this->deleteImage($task, $request);

        $task->image_path = $this->uploadImage($task, $request);

        if ($task->image_path !== "") {
            $task->save();
        }
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
     * @param $keywords
     * @return mixed
     */
    public function searchFullTask($keywords)
    {
        $keywords_array = $this->multi_explode([" ", "　"], $keywords);

        $search_tasks = TaskFullText::join('tasks', 'task_full_texts.task_id', '=', 'tasks.id')
            ->join('folders', 'task_full_texts.folder_id', '=', 'folders.id')
            ->select('folders.user_id',
                'task_full_texts.folder_id',
                'task_full_texts.task_id',
                'folders.title as folder_title',
                'tasks.title as task_title',
                'task_full_texts.full_text')
            ->where('user_id', Auth::id())
            ->where(function ($query) use($keywords_array) {
                foreach ($keywords_array as $keyword) {
                    $query->where('full_text', 'like', "%{$keyword}%");
                }
            })->select('task_full_texts.folder_id',
                'task_full_texts.task_id',
                'folders.title as folder_title',
                'tasks.title as task_title')
            ->get();

        return $search_tasks;
    }

    //複数の区切り文字を使用し、文字列を配列化する。
    private function multi_explode ($delimiters,$string) {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }


    /**
     * @param $task
     * @param $request
     * @return mixed
     * @throws Exception
     */
    private function uploadImage($task, $request)
    {
        if ($request->has('image')) {
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('task_image', $image, 'public');
            if (empty($path)) {
                throw new Exception('画像のアップロードに失敗しました。');
            }
            $image_path = Storage::disk('s3')->url($path);
        } else {
            $image_path = $task->image_path;
        }

        return $image_path;
    }

    /**
     * @param $task
     * @param $request
     */
    private function deleteImage($task, $request)
    {
        $image_path = parse_url($task->image_path, PHP_URL_PATH);

        if ($request->has('image') &&
            Storage::disk('s3')->exists($image_path)
        ) {
            Storage::disk('s3')->delete($image_path);
        }
    }

    /**
     * @return string
     */
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
