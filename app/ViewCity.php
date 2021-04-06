<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\ViewCity
 *
 * @property int $month_key
 * @property string|null $city
 * @property int $total_views
 * @property string $created_at
 * @method static Builder|ViewCity newModelQuery()
 * @method static Builder|ViewCity newQuery()
 * @method static Builder|ViewCity query()
 * @method static Builder|ViewCity whereCity($value)
 * @method static Builder|ViewCity whereCreatedAt($value)
 * @method static Builder|ViewCity whereMonthKey($value)
 * @method static Builder|ViewCity whereTotalViews($value)
 * @mixin \Eloquent
 */
class ViewCity extends Model
{
    protected $table = 'view_cities';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month_key',
        'city',
        'total_views',
        'created_at',
    ];


    public static function monthly(): Collection
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym'));
        $end_month_key = request()->input('end_month_key', $start_month_key);

        return DB::table('view_cities')
            ->selectRaw('
                city,
                sum(total_views) as total_views
            ')
            ->whereBetween('month_key', [$start_month_key, $end_month_key])
            ->groupBy('city')
            ->orderByRaw('sum(total_views) desc')
            ->take(10)
            ->get();
    }
}
