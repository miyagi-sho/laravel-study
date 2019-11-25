<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        echo "未完了タスクを通知\n";
    }
}
