<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $userQuantity = 10;
        factory(User::class, $userQuantity)->create();

        $categoryQuantity = 10;
        factory(Category::class, $categoryQuantity)->create();

        $productQuantity = 1000;
        factory(Product::class, $productQuantity)->create()->each(function($product){
            $categories = Category::all()->random(rand(1,5))->pluck('id');
            $product->categories()->attach($categories);
        });
    }
}
