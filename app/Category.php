<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'parent_id', 'metakey', 'metadesc', 'media_id', 'user_id'];

    protected $appends = ['url', 'permalink', 'created_ago', 'updated_ago'];

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

    public function media()
    {
        return $this->belongsTo('App\Media', 'media_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    public function comments()
    {
        return $this->hasMany('App\CategoryComment', 'reference_id');
    }

    public function getUrlAttribute()
    {
        return url('categories/' . $this->id . '/' . Str::slug($this->name));
    }

    public function getPermalinkAttribute()
    {
        return url('categories/' . $this->id);
    }

    public function getCreatedAgoAttribute()
    {
        return empty($this->created_at)? null : $this->created_at->diffForHumans();
    }

    public function getUpdatedAgoAttribute()
    {
        return empty($this->updated_at)? null : $this->updated_at->diffForHumans();
    }


    public static function invalidateCache()
    {
        Cache::forget('categories');
        Cache::forget('categories.lov');
    }
}
