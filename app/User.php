<?php

namespace App;

use App\Traits\RelativeTime;
use App\Traits\CustomEmailSetup;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function media(): HasMany
    {
        return $this->hasMany('App\Media');
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
