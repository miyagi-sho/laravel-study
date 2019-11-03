<?php

namespace App\Business\Task;

interface TaskBusinessLogicInterface
{
    /**
     * taskテーブルをランダムで作成
     *
     * @param $task
     * @return mixed
     */
    public function randomShare($task);

    /**
     * shareで1レコード取得
     *
     * @param $share
     * @return mixed
     */
    public function searchTaskByShare($share);
}
