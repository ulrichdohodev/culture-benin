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
        // Configure view paths to use Front1/resources/views
        $this->app['view']->addLocation(base_path('Front1/resources/views'));
        
        // Configure Vite to use Front1 directory
        Vite::useHotFile(base_path('Front1/public/hot'))
            ->useBuildDirectory('build');
        
        // Ensure the `role` middleware alias is registered (defensive).
        if (isset($this->app['router'])) {
            $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);
        }
    }
}
