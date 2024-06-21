<?php

namespace App\Providers;

use App\Services\EkoMarkDownParse;
use Illuminate\Support\ServiceProvider;

class EkoMarkDownParseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('ekoMarkDownParse', function ($app) {
            return new EkoMarkDownParse();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
