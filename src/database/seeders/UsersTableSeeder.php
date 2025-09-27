<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'name' => '山田 太郎',
            'email' => '1234@abcd1',
            'password' => '12345678',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '山田 次郎',
            'email' => '1234@abcd2',
            'password' => '12345678',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '山田 三郎',
            'email' => '1234@abcd3',
            'password' => '12345678',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '山田 四郎',
            'email' => '1234@abcd4',
            'password' => '12345678',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '山田 五郎',
            'email' => '1234@abcd5',
            'password' => '12345678',
            'created_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 25, 12, 57, 0),
        ];
        DB::table('users')->insert($param);
    }
}
