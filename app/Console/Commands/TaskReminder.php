<?php

namespace App\Console\Commands;

use App\Folder;
use App\Mail\BecomeAtOneInTheAfternoon;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TaskReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:unfinish-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '未完了のタスクをまとめて通知する。';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //翌日までのタスクを探し出す。
        $date = Carbon::tomorrow();
        $date = $date->format('Y-m-d');
//        検証用
//        $date = '2025-12-8';
        //ここがちょっとおかしい。
        //多分、日付が一致していて、未着手のタスクと
        //日付かかわらず、着手中のタスクを
        //取得する形になっている。
        $tasks = Task::where('due_date', '=', $date)
            ->where('status', Task::STATUS_NAME['not_start'])
            ->orWhere('status', Task::STATUS_NAME['start'])
            ->get();

        //未完了タスクを含むフォルダを探し出す。
        $folders_ids = [];
        foreach ($tasks as $task) {
            $id = $task->folder_id;
            $folders_ids[] = $id;
        }
        $folders_ids = array_unique($folders_ids);
        $folders = Folder::whereIn('id', $folders_ids)->get();

        //上記フォルダのユーザーを探し出す。
        $users_ids = [];
        foreach ($folders as $folder) {
            $id = $folder->user_id;
            $users_ids[] = $id;
        }
        $users_ids = array_unique($users_ids);
        $users = User::whereIn('id', $users_ids)->get();

        //ユーザーごとに情報を渡し、メールを送信
        foreach ($users as $user) {
            //未完了タスクを持つフォルダをuserごとに処理する
            $reminder_folders = [];
            foreach ($folders as $folder) {
                if ($folder->user_id === $user->id) {
                    $reminder_folders[] = $folder;
                }
            }

            //未完了タスクをフォルダごとに取得する
            $reminder_tasks = [];
            for ($i = 0; $i < count($reminder_folders); $i++) {
                $reminder_tasks[$i] = [];
                for ($t = 0; $t < count($tasks); $t++) {
                    $reminder_task = array_filter(array($tasks[$t]), function($task) use($reminder_folders, $i) {
                        return $task->folder_id === $reminder_folders[$i]->id;
                    });

                    if ($reminder_task) {
                        $reminder_tasks[$i][] = $reminder_task;
                    }
                }
            }

//            メールを送信
            Mail::to($user)->send(new BecomeAtOneInTheAfternoon($user, $reminder_folders, $reminder_tasks));
        }
    }
}
