<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Usuario;
use App\Observers\UsuarioObserver;

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
        //
        Usuario::observe(UsuarioObserver::class);
    }
}
