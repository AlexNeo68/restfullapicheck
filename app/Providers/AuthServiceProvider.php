<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addSeconds(30));
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
