<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = ['page_id', 'body_json', 'body_html', 'editor'];

    public function page()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }
}
