<?php

namespace App\Providers;

use App\Models\Denuncias;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use stdClass;

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
        //Max key length error fix
        Schema::defaultStringLength(191);

        Inertia::share('auth.user', function () {
            if (Auth::user()) {
                $user = Auth::user();
                if (str_contains($user->permission, '3')) {
                    $dadosUsuario = new stdClass();
                    $dadosUsuario->theme = $user->theme;
                    return $dadosUsuario;
                }else{                    
                    $dadosUsuario = new stdClass();
                    $dadosUsuario->theme = $user->theme;
                    return $dadosUsuario;
                }
            }else{
                $dadosUsuario = new stdClass();
                $dadosUsuario->theme = 'solid-light';
                return $dadosUsuario;
            }
        });
    }
}
