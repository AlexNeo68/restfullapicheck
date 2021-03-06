<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    $seller = App\Seller::has('products')->get()->random();
    $buyer = App\User::all()->except($seller->id)->random();
    return [
        'quantity' => $faker->numberBetween(1,5),
        'buyer_id' => $buyer->id,
        'product_id' => $seller->products->random()->id
    ];
});
