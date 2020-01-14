<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DatabaseSetup;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DatabaseSetup::class, function () {
            return new DatabaseSetup();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $example = resolve(DatabaseSetup::class);
        $example->setDatabase();
    }
}
