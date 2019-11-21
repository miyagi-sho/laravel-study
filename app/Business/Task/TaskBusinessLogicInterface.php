<?php

namespace App\Business\Task;

use App\Folder;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Task;

interface TaskBusinessLogicInterface
{
    /**
     * @param Folder $folder
     * @param CreateTask $request
     * @return mixed
     */
    public function create($folder, $request);

    /**
     * @param Task $task
     * @param EditTask $request
     * @return mixed
     */
    public function edit($task, $request);

    /**
     * taskテーブルshareカラムをランダムで作成
     *
     * @param $task
     * @return mixed
     */
    public function randomShare($folder);

    /**
     * shareで1レコード取得
     *
     * @param $share
     * @return mixed
     */
    public function searchTaskByShare($share);
}
