<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class ViewUniqueMonthly extends Model
{
    protected $table = 'views_unique_monthly';

    protected $primaryKey = 'month_key';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['month_key', 'unique_visitors', 'created_at'];

    public static function monthly()
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym'));
        $end_month_key = request()->input('end_month_key', $start_month_key);

        // return ViewUniqueMonthly::whereBetween('month_key', [$start_month_key, $end_month_key])
        //     ->select('month_key', 'unique_visitors')
        //     ->orderBy('month_key')
        //     ->get();

        return DB::table('views_unique_monthly')
            ->selectRaw(
                'round(month_key/1, 0) as month_key,
                round(unique_visitors/1, 0) as unique_visitors'
            )
            ->whereBetween('month_key', [$start_month_key, $end_month_key])
            ->orderByRaw('month_key')
            ->get();
    }
}
