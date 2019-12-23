<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksFullTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_full_texts', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('folder_id');
            $table->integer('task_id');
            //フォルダ名、タスク名、タスク詳細が入る。
            $table->string('full_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks_full_texts');
    }
}
