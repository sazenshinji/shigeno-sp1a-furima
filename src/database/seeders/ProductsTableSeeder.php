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
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'category_id' => 5,
            'condition_id' => 1,
            'seller_id' => 1,
            'buyer_id' => 2,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'HDD',
            'price' => 5000,
            'image_path' => 'images/02_HDD.jpg',
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'category_id' => 2,
            'condition_id' => 2,
            'seller_id' => 1,
            'buyer_id' => null,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => '玉ねぎ3束',
            'price' => 300,
            'image_path' => 'images/03_玉ねぎ3束.jpg',
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'category_id' => 11,
            'condition_id' => 3,
            'seller_id' => 2,
            'buyer_id' => null,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => '革靴',
            'price' => 4000,
            'image_path' => 'images/04_革靴.jpg',
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => '　',
            'description' => 'クラシックなデザインの革靴',
            'category_id' => 5,
            'condition_id' => 4,
            'seller_id' => 2,
            'buyer_id' => null,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'ノートPC',
            'price' => 45000,
            'image_path' => 'images/05_ノートPC.jpg',
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => '　',
            'description' => '高性能なノートパソコン',
            'category_id' => 2,
            'condition_id' => 1,
            'seller_id' => 3,
            'buyer_id' => null,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'マイク',
            'price' => 8000,
            'image_path' => 'images/06_マイク.jpg',
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'category_id' => 2,
            'condition_id' => 2,
            'seller_id' => 3,
            'buyer_id' => null,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'image_path' => 'images/07_ショルダーバッグ.jpg',
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => '　',
            'description' => 'おしゃれなショルダーバッグ',
            'category_id' => 4,
            'condition_id' => 3,
            'seller_id' => 4,
            'buyer_id' => null,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'タンブラー',
            'price' => 500,
            'image_path' => 'images/08_タンブラー.jpg',
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => 'ない',
            'description' => '使いやすいタンブラー',
            'category_id' => 10,
            'condition_id' => 4,
            'seller_id' => 4,
            'buyer_id' => null,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'コーヒーミル',
            'price' => 4000,
            'image_path' => 'images/09_コーヒーミル.jpg',
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'category_id' => 10,
            'condition_id' => 1,
            'seller_id' => 5,
            'buyer_id' => null,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'メイクセット',
            'price' => 2500,
            'image_path' => 'images/10_メイクセット.jpg',
            'is_sold' => false,
            'like_count' => 0,
            'comment_count' => 0,
            'brand' => '　',
            'description' => '便利なメイクアップセット',
            'category_id' => 6,
            'condition_id' => 2,
            'seller_id' => 5,
            'buyer_id' => null,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('products')->insert($param);
    }
}
