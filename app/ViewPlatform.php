<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class ViewPlatform extends Model
{
    protected $table = 'view_platforms';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month_key',
        'platform',
        'total_views',
        'created_at',
    ];

    
    public static function monthly()
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym'));
        $end_month_key = request()->input('end_month_key', $start_month_key);

        return DB::table('view_platforms')
            ->selectRaw('
                platform,  
                sum(total_views) as total_views
            ')
            ->whereBetween('month_key', [$start_month_key, $end_month_key])
            ->groupBy('platform')
            ->orderByRaw('sum(total_views) desc')
            ->take(10)
            ->get();
    }

}
