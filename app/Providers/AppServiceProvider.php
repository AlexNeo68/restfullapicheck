<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;
use App\Mail\UserChangedEmail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Schema::defaultStringLength(191);

        User::created(function($user){
            retry(5, function() use ($user){
                Mail::to($user->email)->send(new UserCreated($user));
            }, 100);
        });

        User::updated(function ($user) {
            retry(5, function () use ($user) {
                if($user->isDirty('email')){
                    Mail::to($user->email)->send(new UserChangedEmail($user));
                }
            }, 100);
        });

        Product::updated(function($product){
            if($product->quantity <=0 && $product->isAvailable()){
                $product->status = Product::UNAVAILABLE_PRODUCT;
                $product->save();
            }

            if($product->quantity > 0 && !$product->isAvailable()){
                $product->status = Product::AVAILABLE_PRODUCT;
                $product->save();
            }
        });
    }
}
