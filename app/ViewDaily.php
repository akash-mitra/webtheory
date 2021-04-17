<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\ViewDaily
 *
 * @property int $date_key
 * @property int $total_views
 * @property int $unique_visitors
 * @property int $bounce_rate
 * @property int|null $avg_visit_duration
 * @property string $created_at
 * @method static Builder|ViewDaily newModelQuery()
 * @method static Builder|ViewDaily newQuery()
 * @method static Builder|ViewDaily query()
 * @method static Builder|ViewDaily whereAvgVisitDuration($value)
 * @method static Builder|ViewDaily whereBounceRate($value)
 * @method static Builder|ViewDaily whereCreatedAt($value)
 * @method static Builder|ViewDaily whereDateKey($value)
 * @method static Builder|ViewDaily whereTotalViews($value)
 * @method static Builder|ViewDaily whereUniqueVisitors($value)
 * @mixin \Eloquent
 */
class ViewDaily extends Model
{
    protected $table = 'views_daily';

    protected $primaryKey = 'date_key';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_key',
        'total_views',
        'unique_visitors',
        'bounce_rate',
        'avg_visit_duration',
        'created_at',
    ];


    public static function daily()
    {
        $start_date_key = request()->input('start_date_key', Carbon::yesterday()->format('Ymd'));
        $end_date_key = request()->input('end_date_key', $start_date_key);

        return ViewDaily::whereBetween('date_key', [$start_date_key, $end_date_key])
            ->select('date_key', 'total_views', 'unique_visitors', 'bounce_rate', 'avg_visit_duration')
            ->orderBy('date_key')
            ->get();
    }


    /**
     * @return Collection
     */
    public static function monthly(): Collection
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym')) . '01';
        $end_month_key = request()->input('end_month_key', Carbon::yesterday()->format('Ym')) . '31';

        return DB::table('views_daily')
            ->selectRaw('
                round(date_key/100) as month_key,
                sum(total_views) as total_views,
                round(avg(bounce_rate)) as bounce_rate,
                round(avg(avg_visit_duration)) as avg_visit_duration'
            )
            ->whereBetween('date_key', [$start_month_key, $end_month_key])
            ->groupByRaw('round(date_key/100)')
            ->orderByRaw('round(date_key/100)')
            ->get();
    }

}
