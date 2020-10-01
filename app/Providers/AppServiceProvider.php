<?php

namespace App\Providers;

use App\Repositories\CustomersRepository;
use App\Services\CustomersDataService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Repositories
        $this->app->singleton(
            CustomersRepository::class,
            \App\Repositories\Concrete\CustomersRepository::class
        );

        // Services
        $this->app->singleton(
            CustomersDataService::class,
            \App\Services\Concrete\CustomersDataService::class
        );
    }
}
