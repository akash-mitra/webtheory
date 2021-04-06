<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\BatchJob
 *
 * @property int $id
 * @property string $batch_date
 * @property string $batch_name
 * @property string $start_datetime
 * @property string|null $end_datetime
 * @property int $start_view_id
 * @property int|null $end_view_id
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|BatchJob newModelQuery()
 * @method static Builder|BatchJob newQuery()
 * @method static Builder|BatchJob query()
 * @method static Builder|BatchJob whereBatchDate($value)
 * @method static Builder|BatchJob whereBatchName($value)
 * @method static Builder|BatchJob whereCreatedAt($value)
 * @method static Builder|BatchJob whereEndDatetime($value)
 * @method static Builder|BatchJob whereEndViewId($value)
 * @method static Builder|BatchJob whereId($value)
 * @method static Builder|BatchJob whereStartDatetime($value)
 * @method static Builder|BatchJob whereStartViewId($value)
 * @method static Builder|BatchJob whereStatus($value)
 * @method static Builder|BatchJob whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BatchJob extends Model
{
    protected $table = 'batch_jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'batch_date',
        'batch_name',
        'start_datetime',
        'end_datetime',
        'start_view_id',
        'end_view_id',
        'status',
    ];
}
