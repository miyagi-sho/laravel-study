<?php

namespace App\Console\Commands;

use App\TasksFullText;
use Illuminate\Support\Facades\DB;
use App\Task;
use Illuminate\Console\Command;

class CreatTaskFullText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fulltext:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'タスクのフルテキストを作成するコマンドです。';

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
        $search_tasks = Task::join('folders','tasks.folder_id', '=', 'folders.id')
            ->select('folders.id as folder_id',
                'tasks.id as task_id',
                'folders.title as folder_title',
                'tasks.title as task_title',
                'tasks.memo')
            ->get();

        DB::table('tasks_full_texts')->delete();
        foreach ($search_tasks as $search_task) {
            $task_full_text = new TasksFullText;
            $task_full_text->folder_id = $search_task->folder_id;
            $task_full_text->task_id = $search_task->task_id;
            $full_text = "{$search_task->folder_title}, {$search_task->task_title}, {$search_task->memo}";
            $task_full_text->full_text = $full_text;
            $task_full_text->save();
        }
    }
}
