<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConditionsTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'name' => '良好',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'name' => '目立った傷や汚れなし',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'name' => 'やや傷や汚れあり',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'name' => '状態が悪い',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('conditions')->insert($param);
    }
}
