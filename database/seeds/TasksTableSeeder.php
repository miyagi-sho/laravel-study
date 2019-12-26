<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TaskReminder検証用データ
        foreach (range(1, 3) as $num) {
            DB::table('tasks')->insert([
                'folder_id' => 1,
                'title' => "プライベート {$num}",
                'status' => $num,
                'due_date' => '2025-12-8',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        foreach (range(1, 3) as $num) {
            DB::table('tasks')->insert([
                'folder_id' => 6,
                'title' => "絵画 {$num}",
                'status' => $num,
                'due_date' => '2025-12-8',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        //全文検索用データ
        $jobs = ['裁判官', '弁護士','検察官'];
        $comics = ['デスノート','バクマン。','プラチナエンド'];

        foreach ($jobs as $job) {
            DB::table('tasks')->insert([
                'folder_id' => 2,
                'title' => $job,
                'status' => 1,
                'due_date' => Carbon::now()->addyear(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        foreach ($comics as $comic) {
            DB::table('tasks')->insert([
                'folder_id' => 4,
                'title' => $comic,
                'status' => 1,
                'due_date' => Carbon::now()->addyear(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
