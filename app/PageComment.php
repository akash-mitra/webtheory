<?php

namespace App;

use App\Traits\RelativeTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\PageComment
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $reference_id
 * @property int $user_id
 * @property string $body
 * @property int $likes
 * @property int $dislikes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read null|string $created_ago
 * @property-read null|string $updated_ago
 * @property-read Page $page
 * @property-read PageComment|null $parent
 * @property-read Collection|PageComment[] $replies
 * @property-read int|null $replies_count
 * @property-read User $user
 * @method static Builder|PageComment newModelQuery()
 * @method static Builder|PageComment newQuery()
 * @method static \Illuminate\Database\Query\Builder|PageComment onlyTrashed()
 * @method static Builder|PageComment query()
 * @method static Builder|PageComment whereBody($value)
 * @method static Builder|PageComment whereCreatedAt($value)
 * @method static Builder|PageComment whereDeletedAt($value)
 * @method static Builder|PageComment whereDislikes($value)
 * @method static Builder|PageComment whereId($value)
 * @method static Builder|PageComment whereLikes($value)
 * @method static Builder|PageComment whereParentId($value)
 * @method static Builder|PageComment whereReferenceId($value)
 * @method static Builder|PageComment whereUpdatedAt($value)
 * @method static Builder|PageComment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|PageComment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PageComment withoutTrashed()
 * @mixin \Eloquent
 */
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
