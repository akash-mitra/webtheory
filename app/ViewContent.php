<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Page;

class ViewContent extends Model
{
    protected $table = 'view_contents';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month_key',
        'content_type',
        'content_id',
        'total_views',
        'created_at',
    ];

    
    public static function monthly()
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym'));
        $end_month_key = request()->input('end_month_key', $start_month_key);

        return DB::table('view_contents')
            ->selectRaw('
                content_id,  
                pages.title,
                sum(total_views) as total_views
            ')
            ->join('pages', 'view_contents.content_id', '=', 'pages.id')
            ->whereBetween('month_key', [$start_month_key, $end_month_key])
            ->where('content_type', 'App\Page')
            ->groupByRaw('content_id, pages.title')
            ->orderByRaw('sum(total_views) desc')
            ->take(10)
            ->get();
    }

}
