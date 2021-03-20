<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Page;
use App\PageComment;
use App\User;
use App\ViewBrowser;
use App\ViewCity;
use App\ViewContent;
use App\ViewCountry;
use App\ViewDaily;
use App\ViewPlatform;
use App\ViewReferrer;
use App\ViewUniqueMonthly;
use Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
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
        return Cache::rememberForever('pages.count', function () {
            return Page::count();
        });
    }

    public function usersCount()
    {
        return Cache::rememberForever('users.count', function () {
            return User::count();
        });
    }

    public function topComments(): JsonResponse
    {
        $comments = PageComment::with(['page', 'user'])
            ->whereNull('parent_id')
            ->latest()
            ->take(10)
            ->get();

        return response()->json($comments);
    }

    public function clearCache(): JsonResponse
    {
        Artisan::call('cache:clear');

        return response()->json('Cache cleared.');
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

    public function uniquemonthly(): Collection
    {
        // return Cache::rememberForever('dashboard.views-unique-monthly', function () {
        return ViewUniqueMonthly::monthly();
        // });
    }


    public function content(): Collection
    {
        // return Cache::rememberForever('dashboard.content', function () {
        return ViewContent::monthly();
        // });
    }

    public function referrer(): Collection
    {
        // return Cache::rememberForever('dashboard.referrer', function () {
        return ViewReferrer::monthly();
        // });
    }

    public function platform(): Collection
    {
        // return Cache::rememberForever('dashboard.platform', function () {
        return ViewPlatform::monthly();
        // });
    }

    public function browser(): Collection
    {
        // return Cache::rememberForever('dashboard.browser', function () {
        return ViewBrowser::monthly();
        // });
    }

    public function country(): Collection
    {
        // return Cache::rememberForever('dashboard.country', function () {
        return ViewCountry::monthly();
        // });
    }

    public function city(): Collection
    {
        // return Cache::rememberForever('dashboard.city', function () {
        // return ViewCity::monthly();
        // });
        return ViewCity::monthly();
    }

}
