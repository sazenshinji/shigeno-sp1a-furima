<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Category_productTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'product_id' => 1,
            'category_id' => 1,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);
        $param = [
            'product_id' => 1,
            'category_id' => 5,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);

        $param = [
            'product_id' => 2,
            'category_id' => 2,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);

        $param = [
            'product_id' => 3,
            'category_id' => 11,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);

        $param = [
            'product_id' => 4,
            'category_id' => 1,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);
        $param = [
            'product_id' => 4,
            'category_id' => 5,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);

        $param = [
            'product_id' => 5,
            'category_id' => 2,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);

        $param = [
            'product_id' => 6,
            'category_id' => 2,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);

        $param = [
            'product_id' => 7,
            'category_id' => 1,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);
        $param = [
            'product_id' => 7,
            'category_id' => 4,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);

        $param = [
            'product_id' => 8,
            'category_id' => 10,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);

        $param = [
            'product_id' => 9,
            'category_id' => 10,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);

        $param = [
            'product_id' => 10,
            'category_id' => 1,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);
        $param = [
            'product_id' => 10,
            'category_id' => 4,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);
        $param = [
            'product_id' => 10,
            'category_id' => 6,
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('category_product')->insert($param);
    }
}
