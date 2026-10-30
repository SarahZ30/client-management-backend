<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Modules\ClientManagement\app\Repositaries\ClientImplementation;
use Modules\ClientManagement\app\Repositaries\ClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // bind the client interface to its implementation
        $this->app->bind(ClientInterface::class, ClientImplementation::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // limit default string length so indexes fit within the key size limit
        Schema::defaultStringLength(191);
    }
}
