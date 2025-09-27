<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(Category_productTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);

    }
}
