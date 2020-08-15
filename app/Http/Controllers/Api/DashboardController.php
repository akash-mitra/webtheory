<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Page;
use App\PageComment;
use App\User;
use App\ViewDaily;
use App\ViewUniqueMonthly;
use App\ViewContent;
use App\ViewReferrer;
use App\ViewPlatform;
use App\ViewBrowser;
use App\ViewCountry;
use App\ViewCity;
use Cache;
use DB;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission']);
    }

    public function pagesCount()
    {
        $count = Cache::rememberForever('pages.count', function () {
            return Page::count();
        });

        return $count;
    }

    public function usersCount()
    {
        $count = Cache::rememberForever('users.count', function () {
            return User::count();
        });

        return $count;
    }

    public function topComments()
    {
        $comments = PageComment::with(['page', 'user'])
            ->whereNull('parent_id')
            ->latest()
            ->take(10)
            ->get();

        return response()->json($comments);
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');

        return response()->json('Saved', 200);
    }


    public function viewsdaily()
    {
        
        // return Cache::rememberForever('dashboard.views-daily', function () {
            return ViewDaily::daily();
        // });
    }


    public function viewsmonthly()
    {
        // return Cache::rememberForever('dashboard.views-monthly', function () {
            return ViewDaily::monthly();
        // });
    }

    public function uniquemonthly()
    {
        // return Cache::rememberForever('dashboard.views-unique-monthly', function () {
            return ViewUniqueMonthly::monthly();
        // });
    }


    public function content()
    {
        // return Cache::rememberForever('dashboard.content', function () {
            return ViewContent::monthly();
        // });
    }

    public function referrer()
    {
        // return Cache::rememberForever('dashboard.referrer', function () {
            return ViewReferrer::monthly();
        // });
    }

    public function platform()
    {
        // return Cache::rememberForever('dashboard.platform', function () {
            return ViewPlatform::monthly();
        // });
    }

    public function browser()
    {
        // return Cache::rememberForever('dashboard.browser', function () {
            return ViewBrowser::monthly();
        // });
    }

    public function country()
    {
        // return Cache::rememberForever('dashboard.country', function () {
            return ViewCountry::monthly();
        // });
    }

    public function city()
    {
        // return Cache::rememberForever('dashboard.city', function () {
            // return ViewCity::monthly();
        // });
        return ViewCity::monthly();
    }

}
