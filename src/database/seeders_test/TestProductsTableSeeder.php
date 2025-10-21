<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'name' => '腕時計',
            'condition_id' => 1,
            'price' => 15000,
            'image_path' => 'images/01_腕時計.jpg',
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'seller_id' => 1,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'HDD',
            'condition_id' => 2,
            'price' => 5000,
            'image_path' => 'images/02_HDD.jpg',
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'seller_id' => 1,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => '玉ねぎ3束',
            'condition_id' => 3,
            'price' => 300,
            'image_path' => 'images/03_玉ねぎ3束.jpg',
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'seller_id' => 2,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => '革靴',
            'condition_id' => 4,
            'price' => 4000,
            'image_path' => 'images/04_革靴.jpg',
            'brand' => '　',
            'description' => 'クラシックなデザインの革靴',
            'seller_id' => 2,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'ノートPC',
            'condition_id' => 1,
            'price' => 45000,
            'image_path' => 'images/05_ノートPC.jpg',
            'brand' => '　',
            'description' => '高性能なノートパソコン',
            'seller_id' => 3,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'マイク',
            'condition_id' => 2,
            'price' => 8000,
            'image_path' => 'images/06_マイク.jpg',
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'seller_id' => 3,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'ショルダーバッグ',
            'condition_id' => 3,
            'price' => 3500,
            'image_path' => 'images/07_ショルダーバッグ.jpg',
            'brand' => '　',
            'description' => 'おしゃれなショルダーバッグ',
            'seller_id' => 4,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'タンブラー',
            'condition_id' => 4,
            'price' => 500,
            'image_path' => 'images/08_タンブラー.jpg',
            'brand' => 'ない',
            'description' => '使いやすいタンブラー',
            'seller_id' => 4,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'コーヒーミル',
            'condition_id' => 1,
            'price' => 4000,
            'image_path' => 'images/09_コーヒーミル.jpg',
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'seller_id' => 5,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'メイクセット',
            'condition_id' => 2,
            'price' => 2500,
            'image_path' => 'images/10_メイクセット.jpg',
            'brand' => '　',
            'description' => '便利なメイクアップセット',
            'seller_id' => 5,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
    }
}
