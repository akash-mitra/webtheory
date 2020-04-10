<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View  extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip', 'user_id', 'at', 'url', 'content_type', 'content_id', 'platform', 'browser', 'version', 'referrer', 
    ];
}