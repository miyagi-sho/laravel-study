<?php

namespace App\Http\Controllers;

use App\Business\Task\TaskBusinessLogicInterface;
use App\Folder;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function __construct(TaskBusinessLogicInterface $task_business_logic)
    {
        $this->task_business_logic =  $task_business_logic;
    }

    /**
     * タスク一覧
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function index(Folder $folder)
    {
        //ユーザーのフォルダを取得する
        $folders = Auth::user()->folders()->get();

        //選ばれたフォルダに紐づくタスクを取得する
        $tasks = $folder->tasks()->get();

        return view('tasks/index',[
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * タスク作成フォーム
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
     public function showCreateForm(Folder $folder)
     {
        return view('tasks/create',[
            'folder_id' => $folder->id
        ]);
     }

     /**
      * タスク作成
      * @param Folder $folder
      * @param CreateTask $request
      * @return \Illuminate\Http\RedirectResponse
      */
    public function create(Folder $folder, CreateTask $request)
    {
        $this->task_business_logic->create( $folder, $request);

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    /**
     * タスク編集フォーム
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * タスク編集
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->task_business_logic->edit( $folder, $task, $request);

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }


    /**
     * シェアURL確認画面
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function share(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);

        if(is_null($task->share)) {
            $this->task_business_logic->randomShare($task);
        }

        return view('tasks/share', [
            'task' => $task,
            'folder' => $folder
        ]);
    }

    /**
     * @param string $share
     * @return \Illuminate\View\View
     */
    public function publicTask(Folder $folder, Task $task, string $share)
    {
        $this->checkRelation($folder, $task);

        $task = $this->task_business_logic->searchTaskByShare($share);

        if(is_null($task)){
            abort(404);
        }

        if($folder->user_id === Auth::id()){
            return view('tasks/detail',[
                'task' => $task,
            ]);
        }else {
            return view('tasks/public', [
                'task' => $task
            ]);
        }
    }

    public function showDetail(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);

        return view('tasks/detail',[
            'task' => $task,
        ]);
    }

    private function checkRelation(Folder $folder, Task $task)
    {
        if($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
}
