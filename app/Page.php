<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use App\Parameter;
use App\Traits\Shareable;

class Page extends Model
{
    use SoftDeletes, Searchable, Shareable;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'summary',
        'metakey',
        'metadesc',
        'media_id',
        'status',
        'access_plan',
        'options',
    ];

    protected $appends = ['url', 'permalink', 'created_ago', 'updated_ago'];

    protected $shareOptions = [
        'columns' => [
            'title' => 'title',
        ],
        'url' => 'url',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'Live');
    }

    public function content()
    {
        return $this->hasMany('App\PageContent');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function media()
    {
        return $this->belongsTo('App\Media', 'media_id');
    }

    public function comments()
    {
        return $this->hasMany('App\PageComment', 'reference_id');
    }

    public function directComments()
    {
        return $this->comments()->whereNull('parent_id');
    }

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
        return empty($this->created_at) ? null : $this->created_at->diffForHumans();
    }

    public function getUpdatedAgoAttribute()
    {
        return empty($this->updated_at) ? null : $this->updated_at->diffForHumans();
    }

    public static function invalidateCache()
    {
        Cache::forget('pages');
        Cache::forget('pages.count');
    }

    public function shouldBeSearchable()
    {
        return Parameter::getKey('SEARCHABLE') && $this->status == 'Live';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $page = $this->toArray();
        $array = array_merge($page, [
            'category_name' => $this->category()->value('name'),
            // 'content' => strip_tags($this->content()->value('body_html')),
        ]);

        return $array;
    }
}
