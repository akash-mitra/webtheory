<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\LoginProvider
 *
 * @property int $id
 * @property int $user_id
 * @property string $provider_user_id
 * @property string $provider
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider whereProviderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginProvider whereUserId($value)
 * @mixin \Eloquent
 */
class LoginProvider extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'provider_user_id', 'provider', 'avatar'];

    /**
     * returns the user associated with
     * this login provider
     */
    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
