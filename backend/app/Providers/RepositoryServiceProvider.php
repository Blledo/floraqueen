<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\{
    CartRepositoryInterface,
    ProductRepositoryInterface,
    VoucherRepositoryInterface,
    VoucherRuleRepositoryInterface
};

use App\Repositories\{
    CartRepository,
    ProductRepository,
    VoucherRepository,
    VoucherRuleRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CartRepositoryInterface::class, 
            CartRepository::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class, 
            ProductRepository::class
        );

        $this->app->bind(
            VoucherRepositoryInterface::class, 
            VoucherRepository::class
        );

        $this->app->bind(
            VoucherRuleRepositoryInterface::class, 
            VoucherRuleRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
