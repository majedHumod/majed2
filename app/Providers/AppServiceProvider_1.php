<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Define gates for user roles
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('trainer', function (User $user) {
            return $user->isTrainer();
        });

        Gate::define('subscriber', function (User $user) {
            return $user->isSubscriber();
        });

        // Add Blade directives for roles
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        Blade::if('trainer', function () {
            return auth()->check() && auth()->user()->isTrainer();
        });

        Blade::if('subscriber', function () {
            return auth()->check() && auth()->user()->isSubscriber();
        });
    }
}