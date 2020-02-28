<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'status', 'media_id'];

    protected $appends = ['url', 'permalink', 'created_ago', 'updated_ago'];

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
        return $this->belongsTo('App\Category', 'category_id');

        // return $this->belongsTo('App\Category', 'category_id')->withDefault([
        //     'name' => 'Uncategorized',
        //     'description' => null
        // ]);
    }

    public function media()
    {
        return $this->belongsTo('App\Media', 'media_id');
    }

    public function comments()
    {
        return $this->hasMany('App\PageComment', 'reference_id');
    }

    // public function getBodyAttribute()
    // {
    //     $contents = $this->content;
    //     if ($contents === null) return '';
    //     else return $contents->body;
    // }

    public function getUrlAttribute()
    {
        return url('pages/' . $this->id . '/' . Str::slug($this->title));
    }


    public function getPermalinkAttribute()
    {
        return url('pages/' . $this->id);
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
        Cache::forget('pages');
    }
}
