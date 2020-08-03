<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Page;

class ViewMonthly extends Model
{
    protected $table = 'views_monthly';

    protected $primaryKey = 'month_key';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month_key',
        'total_views',
        'unique_visitors',
        'content_type',
        'content_id',
        'platform',
        'browser',
        'referrer_domain',
        'country',
        'city',
        'created_at',
    ];

    public static function views()
    {
        $monthKey = \Carbon\Carbon::yesterday()->format('Ym');
        return DB::table('views_monthly')
            ->selectRaw('sum(total_views) as total_views, sum(unique_visitors) as unique_visitors')
            ->where('content_type', 'App\Page')
            ->where('month_key', $monthKey)
            ->first();
    }

    public static function content()
    {
        $monthKey = \Carbon\Carbon::yesterday()->format('Ym');
        $contents = DB::table('views_monthly')
            ->selectRaw('content_id, sum(total_views) as total_views, sum(unique_visitors) as unique_visitors')
            ->where('content_type', 'App\Page')
            ->where('month_key', $monthKey)
            ->groupBy('content_id')
            ->orderByRaw('sum(total_views) desc, sum(unique_visitors) desc, content_id')
            ->take(10)
            ->get();

        return $contents->map(function ($item, $key) {
            $page = Page::firstWhere('id', $item->content_id);
            return [
                'id' => $item->content_id,
                'title' => $page->title,
                'url' => $page->url,
                'total_views' => $item->total_views,
                'unique_visitors' => $item->unique_visitors,
            ];
        });
    }

    public static function referrer()
    {
        $monthKey = \Carbon\Carbon::yesterday()->format('Ym');
        return DB::table('views_monthly')
            ->selectRaw('referrer_domain, sum(total_views) as total_views, sum(unique_visitors) as unique_visitors')
            ->where('content_type', 'App\Page')
            ->where('month_key', $monthKey)
            ->groupBy('referrer_domain')
            ->orderByRaw('sum(total_views) desc, referrer_domain')
            ->take(5)
            ->get();
    }

    public static function platform()
    {
        $monthKey = \Carbon\Carbon::yesterday()->format('Ym');
        return DB::table('views_monthly')
            ->selectRaw('platform, sum(total_views) as total_views, sum(unique_visitors) as unique_visitors')
            ->where('content_type', 'App\Page')
            ->where('month_key', $monthKey)
            ->groupBy('platform')
            ->orderByRaw('sum(total_views) desc, platform')
            ->take(5)
            ->get();
    }

    public static function browser()
    {
        $monthKey = \Carbon\Carbon::yesterday()->format('Ym');
        return DB::table('views_monthly')
            ->selectRaw('browser, sum(total_views) as total_views, sum(unique_visitors) as unique_visitors')
            ->where('content_type', 'App\Page')
            ->where('month_key', $monthKey)
            ->groupBy('browser')
            ->orderByRaw('sum(total_views) desc, browser')
            ->take(5)
            ->get();
    }

    public static function country()
    {
        $monthKey = \Carbon\Carbon::yesterday()->format('Ym');
        return DB::table('views_monthly')
            ->selectRaw('country, sum(total_views) as total_views, sum(unique_visitors) as unique_visitors')
            ->where('content_type', 'App\Page')
            ->where('month_key', $monthKey)
            ->groupBy('country')
            ->orderByRaw('sum(total_views) desc, country')
            ->get();
    }

    public static function city()
    {
        $monthKey = \Carbon\Carbon::yesterday()->format('Ym');
        return DB::table('views_monthly')
            ->selectRaw('city, sum(total_views) as total_views, sum(unique_visitors) as unique_visitors')
            ->where('content_type', 'App\Page')
            ->where('month_key', $monthKey)
            ->groupBy('city')
            ->orderByRaw('sum(total_views) desc, city')
            ->get();
    }
}
