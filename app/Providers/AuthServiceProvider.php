<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Carbon;
use App\Buyer;
use App\User;
use App\Seller;
use App\Transaction;
use App\Product;
use App\Policies\BuyerPolicy;
use App\Policies\UserPolicy;
use App\Policies\SellerPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\ProductPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
        User::class => UserPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-actions', function ($user){
            return $user->isAdmin();
        });

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();
        Passport::tokensCan([
            'purchase-products' => 'Создание транзакций по покупке товара',
            'manage-products' => 'Управление товарами, - операции создания, чтения, редактирования, удаления товара',
            'manage-account' => 'Управление своим аккаунтом, просмотр своих данных, изменение их, если пользователь админ то просматривать пароль нельзя, удалять аккаунт нельзя',
            'read-general' => 'Просмотр основной информации о категориях купленных товаров, купленных товаров, категорий проданных товаров, проданных товаров, списков транзакций',
        ]);
    }
}
