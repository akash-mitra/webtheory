<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Menu
 *
 * @property int $id
 * @property string $title
 * @property string|null $alias
 * @property int|null $parent_id
 * @property int $sequence_num
 * @property int $menuable_id
 * @property string $menuable_type
 * @property bool $home
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|\Eloquent $menuable
 * @property-read Collection|Menu[] $submenus
 * @property-read int|null $submenus_count
 * @method static Builder|Menu home()
 * @method static Builder|Menu newModelQuery()
 * @method static Builder|Menu newQuery()
 * @method static Builder|Menu query()
 * @method static Builder|Menu whereAlias($value)
 * @method static Builder|Menu whereCreatedAt($value)
 * @method static Builder|Menu whereHome($value)
 * @method static Builder|Menu whereId($value)
 * @method static Builder|Menu whereMenuableId($value)
 * @method static Builder|Menu whereMenuableType($value)
 * @method static Builder|Menu whereParentId($value)
 * @method static Builder|Menu whereSequenceNum($value)
 * @method static Builder|Menu whereTitle($value)
 * @method static Builder|Menu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    protected $fillable = [
        'title',
        'alias',
        'parent_id',
        'sequence_num',
        'menuable_id',
        'menuable_type',
        'home',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'home' => 'boolean',
    ];

    /**
     * Get the model that the menu belongs to.
     */
    public function menuable(): MorphTo
    {
        return $this->morphTo();
    }

    public function submenus(): HasMany
    {
        return $this->hasMany('App\Menu', 'parent_id');
    }

    public function hasContent(): int
    {
        return $this->submenus()->count();
    }

    public function scopeHome($query)
    {
        return $query->where('home', '=', 1);
    }

    public static function invalidateCache()
    {
        Cache::forget('menus');
        Cache::forget('home-menu');
    }
}
