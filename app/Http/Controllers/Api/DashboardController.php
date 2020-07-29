<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Page;
use App\PageComment;
use App\User;
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

    public function views()
    {
        return Cache::remember('dashboard.views', now()->addMinutes(60), function () {
            return DB::table('views_monthly')
                ->select(
                    DB::raw(
                        'sum(total_views) as total_views, sum(unique_vistors) as unique_visitors'
                    )
                )
                ->where('content_type', 'App\Page')
                ->get();
        });
    }

    public function daily()
    {
        return Cache::remember('dashboard.daily', now()->addMinutes(60), function () {
            $start = now()
                ->subDays(8)
                ->format('Ymd');
            $end = now()->format('Ymd');
            return DB::table('views_daily')
                ->select(
                    DB::raw(
                        'date_key, sum(total_views) as total_views, sum(unique_vistors) as unique_vistors'
                    )
                )
                ->where('content_type', 'App\Page')
                ->whereBetween('date_key', [$start, $end])
                ->groupBy('date_key')
                ->get();
        });
    }

    public function content()
    {
        return Cache::remember('dashboard.content', now()->addMinutes(60), function () {
            return DB::table('views_monthly')
                ->select(
                    DB::raw(
                        'content_id, sum(total_views) as total_views, sum(unique_vistors) as unique_vistors'
                    )
                )
                ->where('content_type', 'App\Page')
                ->groupBy('content_id')
                ->get();
        });
    }

    public function referrer()
    {
        return Cache::remember('dashboard.referrer', now()->addMinutes(60), function () {
            return DB::table('views_monthly')
                ->select(
                    DB::raw(
                        'referrer_domain, sum(total_views) as total_views, sum(unique_vistors) as unique_vistors'
                    )
                )
                ->where('content_type', 'App\Page')
                ->groupBy('referrer_domain')
                ->get();
        });
    }

    public function platform()
    {
        return Cache::remember('dashboard.platform', now()->addMinutes(60), function () {
            return DB::table('views_monthly')
                ->select(
                    DB::raw(
                        'platform, sum(total_views) as total_views, sum(unique_vistors) as unique_vistors'
                    )
                )
                ->where('content_type', 'App\Page')
                ->groupBy('platform')
                ->get();
        });
    }

    public function browser()
    {
        return Cache::remember('dashboard.browser', now()->addMinutes(60), function () {
            return DB::table('views_monthly')
                ->select(
                    DB::raw(
                        'browser, sum(total_views) as total_views, sum(unique_vistors) as unique_vistors'
                    )
                )
                ->where('content_type', 'App\Page')
                ->groupBy('browser')
                ->get();
        });
    }

    public function country()
    {
        return Cache::remember('dashboard.country', now()->addMinutes(60), function () {
            return DB::table('views_monthly')
                ->select(
                    DB::raw(
                        'country, sum(total_views) as total_views, sum(unique_vistors) as unique_vistors'
                    )
                )
                ->where('content_type', 'App\Page')
                ->groupBy('country')
                ->get();
        });
    }

    public function city()
    {
        return Cache::remember('dashboard.city', now()->addMinutes(60), function () {
            return DB::table('views_monthly')
                ->select(
                    DB::raw(
                        'city, sum(total_views) as total_views, sum(unique_vistors) as unique_vistors'
                    )
                )
                ->where('content_type', 'App\Page')
                ->groupBy('city')
                ->get();
        });
    }
}
