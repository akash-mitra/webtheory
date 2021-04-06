<?php

namespace App;

use App\Traits\RelativeTime;
use App\Traits\CustomEmailSetup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Laravel\Cashier\Billable;
use Illuminate\Support\Carbon;
use App\Mail\ResetPasswordLink;
use App\Mail\VerifyEmailAddress;
use App\Plugins\EnableDummyAvatar;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Laravel\Cashier\Subscription;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property string $role
 * @property string|null $avatar
 * @property string|null $about_me
 * @property string|null $gender
 * @property string|null $dob
 * @property string|null $profile
 * @property array|null $preferences
 * @property string $public_id
 * @property string|null $google2fa_secret
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $stripe_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property string|null $trial_ends_at
 * @property-read Collection|Asset[] $assets
 * @property-read int|null $assets_count
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|CategoryComment[] $categoryComments
 * @property-read int|null $category_comments_count
 * @property-read null|string $created_ago
 * @property-read null|string $updated_ago
 * @property-read mixed $url
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PageComment[] $pageComments
 * @property-read int|null $page_comments_count
 * @property-read Collection|Page[] $pages
 * @property-read int|null $pages_count
 * @property-read Collection|Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read Collection|Template[] $templates
 * @property-read int|null $templates_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static Builder|User query()
 * @method static Builder|User whereAboutMe($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCardBrand($value)
 * @method static Builder|User whereCardLastFour($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereDob($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereGender($value)
 * @method static Builder|User whereGoogle2faSecret($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePreferences($value)
 * @method static Builder|User whereProfile($value)
 * @method static Builder|User wherePublicId($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRole($value)
 * @method static Builder|User whereStripeId($value)
 * @method static Builder|User whereTrialEndsAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, Billable, EnableDummyAvatar, CustomEmailSetup, RelativeTime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'role',
        'avatar',
        'about_me',
        'gender',
        'dob',
        'profile',
        'preferences',
        'public_id',
        'google2fa_secret',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'trial_ends_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'trial_ends_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'preferences' => 'array',
    ];

    protected $appends = ['created_ago', 'updated_ago', 'url'];

    public function categories(): HasMany
    {
        return $this->hasMany('App\Category');
    }

    public function pages(): HasMany
    {
        return $this->hasMany('App\Page');
    }

    public function assets(): HasMany
    {
        return $this->hasMany('App\Asset');
    }

    public function categoryComments(): HasMany
    {
        return $this->hasMany('App\CategoryComment');
    }

    public function pageComments(): HasMany
    {
        return $this->hasMany('App\PageComment');
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    public function isAuthor(): bool
    {
        return $this->role == 'author';
    }

    public function receiveMail(): bool
    {
        if (in_array('mail', $this->preferences)) {
            return true;
        }
        return false;
    }

    public function getUrlAttribute()
    {
        return route('profile.show', $this->public_id);
    }

    public function providers($provider = null)
    {
        if (empty($provider)) {
            return $this->hasMany(LoginProvider::class);
        } else {
            return $this->hasOne(LoginProvider::class)->where('provider', $provider);
        }
    }

    public function createOrUpdateProvider(string $provider, $providerUser): bool
    {
        $authProvider = $this->providers($provider)->first();

        if (empty($authProvider)) {
            $this->providers()->create([
                'provider' => $provider,
                'provider_user_id' => $providerUser->getId(),
                'avatar' => $providerUser->getAvatar(),
            ]);
        } else {
            $authProvider->avatar = $providerUser->getAvatar();
            $authProvider->save();
        }

        $this->avatar = $providerUser->getAvatar();

        return $this->save();
    }

    public static function findByPublicId($publicId)
    {
        $user = User::where('public_id', $publicId)->first();

        if ($user === null) {
            abort(404, 'User Not Found');
        }

        return $user;
    }

    public static function invalidateCache()
    {
        Cache::forget('users.count');
    }

    /**
     * This method is a override of the original method present in the
     * Illuminate\Auth\MustVerifyEmail trait. This override has been
     * done to make sure that verify user email is sent via our own
     * emailing Job, instead of Laravel's default email job.
     */
    public function sendEmailVerificationNotification()
    {
        $this->sendEmail($this->email, new VerifyEmailAddress($this));
    }

    /**
     * This method is a override of the original method present in the
     * Illuminate\Auth\Passwords\CanResetPassword trait. This over-
     * ride has been done to make sure that verify user email is
     * sent via our own emailing Job, instead of Laravel's.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->sendEmail($this->email, new ResetPasswordLink($this, $token));
    }

    public function verificationUrl(): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->email),
            ]
        );
    }
}
