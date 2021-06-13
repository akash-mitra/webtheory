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
 * Class CategoryComment
 *
 * @package App
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
 * @property-read Category $category
 * @property-read null|string $created_ago
 * @property-read null|string $updated_ago
 * @property-read CategoryComment|null $parent
 * @property-read Collection|CategoryComment[] $replies
 * @property-read int|null $replies_count
 * @property-read User $user
 * @method static Builder|CategoryComment newModelQuery()
 * @method static Builder|CategoryComment newQuery()
 * @method static \Illuminate\Database\Query\Builder|CategoryComment onlyTrashed()
 * @method static Builder|CategoryComment query()
 * @method static Builder|CategoryComment whereBody($value)
 * @method static Builder|CategoryComment whereCreatedAt($value)
 * @method static Builder|CategoryComment whereDeletedAt($value)
 * @method static Builder|CategoryComment whereDislikes($value)
 * @method static Builder|CategoryComment whereId($value)
 * @method static Builder|CategoryComment whereLikes($value)
 * @method static Builder|CategoryComment whereParentId($value)
 * @method static Builder|CategoryComment whereReferenceId($value)
 * @method static Builder|CategoryComment whereUpdatedAt($value)
 * @method static Builder|CategoryComment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|CategoryComment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CategoryComment withoutTrashed()
 * @mixin \Eloquent
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
