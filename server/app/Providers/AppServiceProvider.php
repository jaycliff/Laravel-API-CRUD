<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// https://stackoverflow.com/questions/42244541/laravel-migration-error-syntax-error-or-access-violation-1071-specified-key-wa
use Illuminate\Database\Schema\Builder; // Import Builder where defaultStringLength method is defined

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
        Builder::defaultStringLength(191); // Update defaultStringLength
    }
}
