<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LikesTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'product_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('likes')->insert($param);
        $param = [
            'product_id' => 1,
            'user_id' => 2,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('likes')->insert($param);
        $param = [
            'product_id' => 2,
            'user_id' => 2,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('likes')->insert($param);
    }
}
