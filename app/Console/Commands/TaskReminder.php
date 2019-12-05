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
//        $date = Carbon::tomorrow();
//        $date = $date->format('Y-m-d');
        $date = '2019-12-5';
        //明日までの未完了タスクを探し出す。
        $tasks = Task::where('due_date', '=', $date)
            ->where('status', '1')
            ->orWhere('status', '2')
            ->get();

        //上記タスクのフォルダを探し出す。
        $folders = 0;
        foreach ($tasks as $task) {
            if ($folders === 0) {
                $folders = Folder::where('id', $task->folder_id)->get();
            } else {
                $folder = Folder::where('id', $task->folder_id)->first();
                //$folders内に同一フォルダがなければ、$foldersに追加する。
                $folders_id = [];
                for($i = 0; $i < count($folders); $i++){
                    $id = $folders[$i]->id;
                    $folders_id[] = $id;
                }
                if (in_array($folder->id, $folders_id) === false){
                    $folders[] = $folder;
                }
            }
        }

        //そのフォルダのuser_idのと一致するuserを探し出す。
        $users = 0;
        foreach ($folders as $folder) {
            if ($users === 0) {
                $users = User::where('id', $folder->user_id)->get();
            } else {
                $user = User::where('id', $folder->user_id)->first();
                //$users内に同一フォルダがなければ、$usersに追加する。
                $users_id = [];
                for($i = 0; $i < count($users); $i++){
                    $id = $users[$i]->id;
                    $users_id[] = $id;
                }
                if (in_array($user->id, $users_id) === false){
                    $users[] = $user;
                }
            }
        }

        //ユーザーごとに情報を渡し、メールを送信
        foreach ($users as $user) {
            $folder = [];
            foreach ($folders as $f) {
                if ($f->user_id === $user->id) {
                    $folder[] = $f;
                }
            }

            $task = [];
            for ($i = 0; $i < count($folder); $i++) {
                    $task[$i] = Task::where('folder_id', $folder[$i]->id)
                        ->where('due_date', '=', $date)
                        ->where('status', '1')
                        ->orWhere('status', '2')
                        ->get();
            }
            Mail::to($user)->send(new BecomeAtOneInTheAfternoon($user, $folder, $task));
        }

//        for ($i = 0; $i < count($task); $i++) {
//            echo $task[$i];
//        }

//        echo $task;
//        echo $folders[0]->id;
    }
}
