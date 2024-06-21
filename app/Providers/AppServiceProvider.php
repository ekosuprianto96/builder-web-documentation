<?php

namespace App\Providers;

use App\Decorators\EkoRoute;
use App\Services\LaravelTheme;
use App\Repositories\ProjectRepositori;
use Illuminate\Support\ServiceProvider;
use App\Contracts\ProjectRepositoriesInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LaravelTheme::class, function($app) {
            return new LaravelTheme();
        });

        $this->app->bind(ProjectRepositori::class, function ($app) {
            return new ProjectRepositori();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
