<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\ViewBrowser
 *
 * @property int $month_key
 * @property string|null $browser
 * @property int $total_views
 * @property string $created_at
 * @method static Builder|ViewBrowser newModelQuery()
 * @method static Builder|ViewBrowser newQuery()
 * @method static Builder|ViewBrowser query()
 * @method static Builder|ViewBrowser whereBrowser($value)
 * @method static Builder|ViewBrowser whereCreatedAt($value)
 * @method static Builder|ViewBrowser whereMonthKey($value)
 * @method static Builder|ViewBrowser whereTotalViews($value)
 * @mixin \Eloquent
 */
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


    /**
     * Returns total views per browser types.
     *
     * @return Collection
     */
    public static function monthly(): Collection
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym'));
        $end_month_key = request()->input('end_month_key', $start_month_key);

        return DB::table('view_browsers')
            ->selectRaw('
                browser,
                sum(total_views) as total_views
            ')
            ->whereBetween('month_key', [$start_month_key, $end_month_key])
            ->whereNotNull('browser')
            ->where('browser', 'NOT LIKE', "%bot%")
            ->where('browser', 'NOT LIKE', "%Bot%")
            ->groupBy('browser')
            ->orderByRaw('sum(total_views) desc')
            ->take(10)
            ->get();
    }

}
