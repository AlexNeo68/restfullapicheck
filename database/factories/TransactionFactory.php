<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Transaction;
use App\Seller;
use App\User;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    $seller = Seller::has('products')->get()->random();
    $buyer = User::all()->except($seller->id)->random();
    return [
        'quantity' => $faker->numberBetween(1,5),
        'buyer_id' => $buyer->id,
        'product_id' => $seller->products->random()->id,
    ];
});
