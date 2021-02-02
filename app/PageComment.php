<?php

namespace App;

use App\Traits\RelativeTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageComment extends Model
{
    use SoftDeletes, RelativeTime;

    protected $fillable = ['parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes'];

    protected $appends = ['created_ago', 'updated_ago'];

    protected $touches = ['parent'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PageComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(PageComment::class, 'parent_id')->latest('updated_at');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'reference_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isReply(): bool
    {
        return $this->parent_id != null;
    }
}
