<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = ['page_id', 'body'];
    
    public function page()
    {
        return $this->belongsTo('App\PageContent', 'page_id');
    }
}
