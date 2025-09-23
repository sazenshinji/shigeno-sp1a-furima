<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '腕時計',
            'price' => 15000,
            'image_path' => 'images/01_腕時計.jpg',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'HDD',
            'price' => 5000,
            'image_path' => 'images/02_HDD.jpg',
            'description' => '高速で信頼性の高いハードディスク',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => '玉ねぎ3束',
            'price' => 300,
            'image_path' => 'images/03_玉ねぎ3束.jpg',
            'description' => '新鮮な玉ねぎ3束のセット',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => '革靴',
            'price' => 4000,
            'image_path' => 'images/04_革靴.jpg',
            'description' => 'クラシックなデザインの革靴',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'ノートPC',
            'price' => 45000,
            'image_path' => 'images/05_ノートPC.jpg',
            'description' => '高性能なノートパソコン',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'マイク',
            'price' => 8000,
            'image_path' => 'images/06_マイク.jpg',
            'description' => '高音質のレコーディング用マイク',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'image_path' => 'images/07_ショルダーバッグ.jpg',
            'description' => 'おしゃれなショルダーバッグ',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'タンブラー',
            'price' => 500,
            'image_path' => 'images/08_タンブラー.jpg',
            'description' => '使いやすいタンブラー',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'コーヒーミル',
            'price' => 4000,
            'image_path' => 'images/09_コーヒーミル.jpg',
            'description' => '手動のコーヒーミル',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'メイクセット',
            'price' => 2500,
            'image_path' => 'images/10_メイクセット.jpg',
            'description' => '便利なメイクアップセット',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0)
        ];
        DB::table('products')->insert($param);
    }
}
