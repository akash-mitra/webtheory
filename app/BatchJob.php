<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
