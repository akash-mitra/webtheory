<?php

namespace App;

use Illuminate\Support\Str;
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
    public function menuable()
    {
        return $this->morphTo();
        // return $this->morphTo(__FUNCTION__, 'menuable_type', 'menuable_id');
    }

    public function submenus()
    {
        return $this->hasMany('App\Menu', 'parent_id');
    }

    public function hasContent()
    {
        return $this->submenus()->count();
    }

    public static function invalidateCache()
    {
        Cache::forget('menus');
    }
}
