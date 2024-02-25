<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\MailService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('mail_service', MailService::class);
        $this->app->bind('auth_service', AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
