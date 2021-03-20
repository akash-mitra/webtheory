<?php

namespace App;

use App\Traits\RelativeTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CategoryComment
 * @package App
 */
class CategoryComment extends Model
{
    use SoftDeletes;
    use RelativeTime;

    protected $fillable = ['parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes'];

    protected $appends = ['created_ago', 'updated_ago'];

    protected $touches = ['parent'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo('App\CategoryComment', 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany('App\CategoryComment', 'parent_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Category', 'reference_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function isReply(): bool
    {
        return $this->parent_id != null;
    }
}
