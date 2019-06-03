<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Product::class, 1000)->create()->each(function($product){
            $categories = App\Category::all()->random(rand(1,5))->pluck('id');
            $product->categories()->attach($categories);
        });
    }
}
