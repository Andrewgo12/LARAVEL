<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class HuvServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::share('sistema_nombre', 'Sistema HUV');
        View::share('sistema_version', '2.0.0');
    }
}
