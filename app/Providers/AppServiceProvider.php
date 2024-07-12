<?php

namespace App\Providers;

use App\Services\User\Interface\UserInterface;
use App\Services\User\UserService;
use App\Services\Voucher\Interface\VoucherInterface;
use App\Services\Voucher\VoucherService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserService::class);
        $this->app->bind(VoucherInterface::class, VoucherService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
