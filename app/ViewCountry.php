<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\ViewCountry
 *
 * @property int $month_key
 * @property string|null $country
 * @property int $total_views
 * @property string $created_at
 * @method static Builder|ViewCountry newModelQuery()
 * @method static Builder|ViewCountry newQuery()
 * @method static Builder|ViewCountry query()
 * @method static Builder|ViewCountry whereCountry($value)
 * @method static Builder|ViewCountry whereCreatedAt($value)
 * @method static Builder|ViewCountry whereMonthKey($value)
 * @method static Builder|ViewCountry whereTotalViews($value)
 * @mixin \Eloquent
 */
class ViewCountry extends Model
{
    protected $table = 'view_countries';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month_key',
        'country',
        'total_views',
        'created_at',
    ];


    public static function monthly(): Collection
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym'));
        $end_month_key = request()->input('end_month_key', $start_month_key);

        return DB::table('view_countries')
            ->selectRaw('
                country,
                sum(total_views) as total_views
            ')
            ->whereBetween('month_key', [$start_month_key, $end_month_key])
            ->groupBy('country')
            ->orderByRaw('sum(total_views) desc')
            ->take(10)
            ->get();
    }

}
