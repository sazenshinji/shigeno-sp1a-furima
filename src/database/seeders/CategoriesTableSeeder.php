<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'name' => 'ファッション',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => '家電',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'インテリア',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'レディース',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'メンズ',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'コスメ',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => '本',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'ゲーム',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'スポーツ',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'キッチン',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'ハンドメード',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'アクセサリー',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'おもちゃ',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'ベビー・キッズ',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('categories')->insert($param);
    }
}
