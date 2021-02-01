<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

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
