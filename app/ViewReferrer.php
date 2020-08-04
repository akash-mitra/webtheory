<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class ViewReferrer extends Model
{
    protected $table = 'view_referrers';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month_key',
        'referrer',
        'total_views',
        'created_at',
    ];

    
    public static function monthly()
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym'));
        $end_month_key = request()->input('end_month_key', $start_month_key);

        return DB::table('view_referrers')
            ->selectRaw('
                referrer,  
                sum(total_views) as total_views
            ')
            ->whereBetween('month_key', [$start_month_key, $end_month_key])
            ->groupBy('referrer')
            ->orderByRaw('sum(total_views) desc')
            ->take(10)
            ->get();
    }

}
