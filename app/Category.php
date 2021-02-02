<?php

namespace App;

use App\Traits\RelativeTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Class Category.
 * A category is used to organise pages or other categories.
 *
 * @package App
 */
class Category extends Model
{
    use SoftDeletes;
    use RelativeTime;

    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'metakey',
        'metadesc',
        'media_id',
        'user_id',
    ];

    protected $appends = ['url', 'permalink', 'created_ago', 'updated_ago'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class)->published();
    }

    public function pagesWithDrafts(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function hasContent(): bool
    {
        return $this->pagesWithDrafts()->count() || $this->subcategories()->count();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CategoryComment::class, 'reference_id');
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
        return url('categories/' . $this->id . '/' . Str::slug($this->name));
    }

    public function getPermalinkAttribute()
    {
        return url('categories/' . $this->id);
    }

    public static function invalidateCache()
    {
        Cache::forget('categories');
        Cache::forget('categories.lov');
    }
}
