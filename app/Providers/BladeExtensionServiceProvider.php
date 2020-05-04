<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
// use Illuminate\Contracts\Support\DeferrableProvider;

class BladeExtensionServiceProvider extends ServiceProvider
{
    public function register()
    {

    }



    public function boot()
    {
        Blade::include('modules.comments', 'comments');
    }
}