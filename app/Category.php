<?php

namespace App;

use App\Traits\RelativeTime;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Class Category.
 *
 * A category is used to organise pages or other categories.
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property string|null $description
 * @property string|null $metakey
 * @property string|null $metadesc
 * @property int|null $media_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $author
 * @property-read Collection|CategoryComment[] $comments
 * @property-read int|null $comments_count
 * @property-read Collection|CategoryComment[] $directComments
 * @property-read int|null $direct_comments_count
 * @property-read null|string $created_ago
 * @property-read mixed $permalink
 * @property-read null|string $updated_ago
 * @property-read mixed $url
 * @property-read Asset|null $media
 * @property-read Collection|Menu[] $menus
 * @property-read int|null $menus_count
 * @property-read Collection|Page[] $pages
 * @property-read int|null $pages_count
 * @property-read Collection|Page[] $pagesWithDrafts
 * @property-read int|null $pages_with_drafts_count
 * @property-read Category|null $parent
 * @property-read Collection|Category[] $subcategories
 * @property-read int|null $subcategories_count
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDeletedAt($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereMediaId($value)
 * @method static Builder|Category whereMetadesc($value)
 * @method static Builder|Category whereMetakey($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 * @mixin Eloquent
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
        return $this->belongsTo(Asset::class, 'media_id');
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
