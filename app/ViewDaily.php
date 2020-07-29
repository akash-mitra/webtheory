<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'viewed_at',
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
