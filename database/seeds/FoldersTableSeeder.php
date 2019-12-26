<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $user = DB::table('users')->first();

        $first_titles = [' プライベート', '　仕事', '　旅行'];
        $second_titles = ['漫画', '彫刻', '絵画'];

        foreach ($first_titles as $title) {
            DB::table('folders')->insert([
                'title' => $title,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        foreach ($second_titles as $title) {
            DB::table('folders')->insert([
                'title' => $title,
                'user_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
