<?php

namespace App;

use App\Traits\RelativeTime;
use App\Traits\Shareable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Page extends Model
{
    use SoftDeletes, Searchable, Shareable, RelativeTime;

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

    protected array $shareOptions = [
        'columns' => [
            'title' => 'title',
        ],
        'url' => 'url',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'Live');
    }

    public function contents(): HasMany
    {
        return $this->hasMany('App\PageContent')->orderBy('display_order');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo('App\Asset', 'media_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany('App\PageComment', 'reference_id');
    }

    public function directComments(): HasMany
    {
        return $this->comments()->whereNull('parent_id');
    }

    public function menus(): MorphMany
    {
        return $this->morphMany(Menu::class, 'menuable');
    }

    public function getUrlAttribute()
    {
        return url('pages/' . $this->id . '/' . Str::slug($this->title));
    }

    public function getPermalinkAttribute()
    {
        return url('pages/' . $this->id);
    }

    public static function invalidateCache()
    {
        Cache::forget('pages');
        Cache::forget('pages.count');
    }

    public function shouldBeSearchable(): bool
    {
        return Parameter::getKey('SEARCHABLE') && $this->status == 'Live';
    }

    /**
     * Returns an array containing the data that can be indexed for this model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $page = $this->toArray();
        return array_merge($page, [
            'category_name' => $this->category()->value('name'),
        ]);
    }
}
