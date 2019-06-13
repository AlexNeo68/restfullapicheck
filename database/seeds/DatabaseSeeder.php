<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            TransactionsTableSeeder::class,
        ]);
    }
}
