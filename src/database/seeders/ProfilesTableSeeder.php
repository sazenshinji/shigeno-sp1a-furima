<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'user_image' => 'images/IMG20231112_R.jpg',
            'username' => 'yamada1',
            'postal_code' => '123-0001',
            'address' => '東京都港区高輪1-1-1',
            'building' => 'ABCマンション101',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => 2,
            'user_image' => 'images/IMG20231112_R.jpg',
            'username' => 'yamada2',
            'postal_code' => '123-0001',
            'address' => '東京都港区高輪1-1-1',
            'building' => 'ABCマンション101',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => 3,
            'user_image' => 'images/IMG20231112_R.jpg',
            'username' => 'yamada3',
            'postal_code' => '123-0001',
            'address' => '東京都港区高輪1-1-1',
            'building' => 'ABCマンション101',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => 4,
            'user_image' => 'images/IMG20231112_R.jpg',
            'username' => 'yamada4',
            'postal_code' => '123-0001',
            'address' => '東京都港区高輪1-1-1',
            'building' => 'ABCマンション101',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => 5,
            'user_image' => 'images/IMG20231112_R.jpg',
            'username' => 'yamada5',
            'postal_code' => '123-0001',
            'address' => '東京都港区高輪1-1-1',
            'building' => 'ABCマンション101',
            'created_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
            'updated_at' => Carbon::create(2025, 9, 23, 12, 57, 0),
        ];
        DB::table('profiles')->insert($param);

    }
}
