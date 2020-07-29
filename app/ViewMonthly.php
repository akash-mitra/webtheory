<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewMonthly extends Model
{
    protected $table = 'views_monthly';

    protected $primaryKey = 'month_key';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month_key',
        'total_views',
        'unique_vistors',
        'content_type',
        'content_id',
        'platform',
        'browser',
        'referrer_domain',
        'country',
        'city',
        'created_at',
    ];
}
