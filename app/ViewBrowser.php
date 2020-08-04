<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class ViewBrowser extends Model
{
    protected $table = 'view_browsers';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month_key',
        'browser',
        'total_views',
        'created_at',
    ];

    
    public static function monthly()
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym'));
        $end_month_key = request()->input('end_month_key', $start_month_key);

        return DB::table('view_browsers')
            ->selectRaw('
                browser,  
                sum(total_views) as total_views
            ')
            ->whereBetween('month_key', [$start_month_key, $end_month_key])
            ->groupBy('browser')
            ->orderByRaw('sum(total_views) desc')
            ->take(10)
            ->get();
    }

}
