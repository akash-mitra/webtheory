<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = ['category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'status'];
    
    protected $appends = ['url', 'created_ago', 'updated_ago'];
    
    public function content()
    {
        return $this->hasOne('App\PageContent');
    }
    
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id')->withDefault([
            'name' => 'Uncategorized',
            'description' => null
        ]);
    }

    public function getBodyAttribute()
    {
        $contents = $this->content;
        if ($contents === null) return '';
        else return $contents->body;
    }

    public function getUrlAttribute()
    {
        return url('pages/' . $this->id . '/' . Str::slug($this->title));
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
