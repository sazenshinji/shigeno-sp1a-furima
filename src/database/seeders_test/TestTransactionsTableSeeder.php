<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionsTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'product_id' => 5,
            'user_id' => 5,
            'datetime' => '2025-07-28 12:30:00',
            'payment_method' => 1,
            'postal_code' => '123-0001',
            'address' => '東京都港区高輪1-1-1',
            'building' => 'ABCマンション101',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('transactions')->insert($param);
        $param = [
            'product_id' => 6,
            'user_id' => 5,
            'datetime' => '2025-07-29 12:30:00',
            'payment_method' => 2,
            'postal_code' => '123-0001',
            'address' => '東京都港区高輪1-1-1',
            'building' => 'ABCマンション101',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('transactions')->insert($param);
        $param = [
            'product_id' => 7,
            'user_id' => 1,
            'datetime' => '2025-06-29 12:30:00',
            'payment_method' => 2,
            'postal_code' => '456-0001',
            'address' => '東京都目黒区上目黒1-1-1',
            'building' => 'ABCマンション202',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('transactions')->insert($param);
    }
}
