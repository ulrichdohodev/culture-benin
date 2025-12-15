<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;

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
        // Use default resources/views; configure Vite for root public dir
        Vite::useHotFile(base_path('public/hot'))
            ->useBuildDirectory('build');
        
        // Ensure the `role` middleware alias is registered (defensive).
        if (isset($this->app['router'])) {
            $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);
        }
    }
}
