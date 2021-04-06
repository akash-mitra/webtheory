<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\ViewContent
 *
 * @property int $month_key
 * @property string $content_type
 * @property int $content_id
 * @property int $total_views
 * @property string $created_at
 * @method static Builder|ViewContent newModelQuery()
 * @method static Builder|ViewContent newQuery()
 * @method static Builder|ViewContent query()
 * @method static Builder|ViewContent whereContentId($value)
 * @method static Builder|ViewContent whereContentType($value)
 * @method static Builder|ViewContent whereCreatedAt($value)
 * @method static Builder|ViewContent whereMonthKey($value)
 * @method static Builder|ViewContent whereTotalViews($value)
 * @mixin \Eloquent
 */
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


    public static function monthly(): Collection
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
