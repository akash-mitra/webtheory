<?php

namespace App;

use App\Traits\RelativeTime;
use App\Traits\Shareable;
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
use Laravel\Scout\Searchable;

/**
 * App\Page
 *
 * @property int $id
 * @property int|null $category_id
 * @property int $user_id
 * @property string $title
 * @property string|null $summary
 * @property string|null $metakey
 * @property string|null $metadesc
 * @property int|null $media_id
 * @property string $status
 * @property string|null $access_plan
 * @property string|null $options
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $author
 * @property-read Category|null $category
 * @property-read Collection|PageComment[] $comments
 * @property-read int|null $comments_count
 * @property-read Collection|PageContent[] $contents
 * @property-read int|null $contents_count
 * @property-read Collection|PageComment[] $directComments
 * @property-read int|null $direct_comments_count
 * @property-read null|string $created_ago
 * @property-read mixed $permalink
 * @property-read null|string $updated_ago
 * @property-read mixed $url
 * @property-read Asset|null $media
 * @property-read Collection|Menu[] $menus
 * @property-read int|null $menus_count
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static \Illuminate\Database\Query\Builder|Page onlyTrashed()
 * @method static Builder|Page published()
 * @method static Builder|Page query()
 * @method static Builder|Page whereAccessPlan($value)
 * @method static Builder|Page whereCategoryId($value)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereDeletedAt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereMediaId($value)
 * @method static Builder|Page whereMetadesc($value)
 * @method static Builder|Page whereMetakey($value)
 * @method static Builder|Page whereOptions($value)
 * @method static Builder|Page whereStatus($value)
 * @method static Builder|Page whereSummary($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Page withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Page withoutTrashed()
 * @mixin Eloquent
 */
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
