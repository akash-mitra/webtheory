<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageComment extends Model
{
    use SoftDeletes;

    protected $fillable = ['parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes'];
    
    protected $appends = ['created_ago', 'updated_ago'];
    
    public function parent()
    {
        return $this->belongsTo('App\PageComment', 'parent_id');
    }

    public function subcomments()
    {
        return $this->hasMany('App\PageComment', 'parent_id');
    }

    public function page()
    {
        return $this->belongsTo('App\Page', 'reference_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getCreatedAgoAttribute()
    {
        return empty($this->created_at)? null : $this->created_at->diffForHumans();
    }
    
    public function getUpdatedAgoAttribute()
    {
        return empty($this->updated_at)? null : $this->updated_at->diffForHumans();
    }
}
