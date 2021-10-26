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
        Blade::include('modules.menu', 'menu');

        /* shows a small user tile like the one in the top right corner of a page */
        Blade::include('modules.userstrip', 'userstrip');

        Blade::include('modules.profilepage', 'profilepage');

        Blade::include('modules.comments', 'comments');

        Blade::include('modules.favicon', 'favicon');

        Blade::include('modules.readtime', 'readtime');

        Blade::include('modules.sharepost', 'sharepost');

        Blade::include('modules.form', 'form');

        Blade::include('modules.ads', 'ads');

        Blade::include('modules.top_pages', 'top_pages');

        Blade::include('modules.recent_pages', 'recent_pages');

        Blade::include('modules.author_pages', 'author_pages');

        Blade::include('modules.maximize_images', 'maximize_images');
    }
}
