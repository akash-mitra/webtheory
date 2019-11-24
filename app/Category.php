<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'parent_id'];
    
    protected $appends = ['url', 'created_ago', 'updated_ago'];

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id')->withDefault();
    }
    
    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    public function subcategories()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

    public function getUrlAttribute()
    {
        return url('categories/' . $this->id . '/' . Str::slug($this->name));
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
