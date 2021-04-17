<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\ViewReferrer
 *
 * @property int $month_key
 * @property string|null $referrer_domain
 * @property int $total_views
 * @property string $created_at
 * @method static Builder|ViewReferrer newModelQuery()
 * @method static Builder|ViewReferrer newQuery()
 * @method static Builder|ViewReferrer query()
 * @method static Builder|ViewReferrer whereCreatedAt($value)
 * @method static Builder|ViewReferrer whereMonthKey($value)
 * @method static Builder|ViewReferrer whereReferrerDomain($value)
 * @method static Builder|ViewReferrer whereTotalViews($value)
 * @mixin \Eloquent
 */
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
        'referrer_domain',
        'total_views',
        'created_at',
    ];


    /**
     * @return Collection
     */
    public static function monthly(): Collection
    {
        $start_month_key = request()->input('start_month_key', Carbon::yesterday()->format('Ym'));
        $end_month_key = request()->input('end_month_key', $start_month_key);

        return DB::table('view_referrers')
            ->selectRaw('
                referrer_domain as referrer,
                sum(total_views) as total_views
            ')
            ->whereBetween('month_key', [$start_month_key, $end_month_key])
            ->groupBy('referrer_domain')
            ->orderByRaw('sum(total_views) desc')
            ->take(10)
            ->get();
    }
}
