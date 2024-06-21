<?php

namespace App\Providers;

use App\Facades\LaravelTheme;
use App\Repositories\PagesRepositori;
use App\Repositories\ProjectRepositori;
use App\Services\EditorGrapesJs;
use Illuminate\Support\ServiceProvider;

class EditorGrapesJsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('editorGrapesJs', function($app) {
            return new EditorGrapesJs(new LaravelTheme, new PagesRepositori, new ProjectRepositori);
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
