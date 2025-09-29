<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'product_id' => 3,
            'user_id' => 3,
            'comment' =>  '購入検討中',
            'date' =>'2025-09-28 12:30:00',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('comments')->insert($param);
        $param = [
            'product_id' => 4,
            'user_id' => 3,
            'comment' =>  '購入検討中',
            'date' => '2025-09-28 12:30:00',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('comments')->insert($param);
        $param = [
            'product_id' => 4,
            'user_id' => 4,
            'comment' =>  'どうしても買いたい。',
            'date' => '2025-09-28 12:30:00',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('comments')->insert($param);
    }
}
