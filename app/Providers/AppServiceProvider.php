<?php

namespace Accordous\Providers;

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
        $this->app->bind(
            'Accordous\Repositories\PropertyRepositoryInterface',
            'Accordous\Repositories\PropertyRepository'
        );

        $this->app->bind(
            'Accordous\Repositories\ContractRepositoryInterface',
            'Accordous\Repositories\ContractRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
