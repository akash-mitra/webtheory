<?php

namespace App;

use App\Template;
use App\Jobs\SendEmail;
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

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, Billable, EnableDummyAvatar;

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
        'preferences',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'trial_ends_at',
        'public_id',
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
        'gender' => 'boolean',
        'preferences' => 'array',
    ];

    protected $appends = ['created_ago', 'updated_ago', 'url'];

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    public function media()
    {
        return $this->hasMany('App\Media');
    }

    public function categorycomments()
    {
        return $this->hasMany('App\CategoryComment');
    }

    public function pagecomments()
    {
        return $this->hasMany('App\PageComment');
    }

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isAuthor()
    {
        return $this->role == 'author';
    }

    public function getCreatedAgoAttribute()
    {
        return optional($this->created_at)->diffForHumans();
    }

    public function getUpdatedAgoAttribute()
    {
        return optional($this->updated_at)->diffForHumans();
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

    public function createOrUpdateProvider(string $provider, $providerUser)
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

    /**
     * This method is a override of the originl method present in the
     * Illuminate\Auth\MustVerifyEmail trait. This override has been
     * done to make sure that verify user email is sent via our own
     * emailing Job, instead of laravel's default email job.
     */
    public function sendEmailVerificationNotification()
    {
        // $this->notify(new VerifyEmail);

        SendEmail::dispatch($this->email, new VerifyEmailAddress($this));
    }

    /**
     * This method is a override of the originl method present in the
     * Illuminate\Auth\Passwords\CanResetPassword trait. This over-
     * ride has been done to make sure that verify user email is
     * sent via our own emailing Job, instead of laravel's.
     */
    public function sendPasswordResetNotification($token)
    {
        // $this->notify(new ResetPasswordNotification($token));

        SendEmail::dispatch($this->email, new ResetPasswordLink($this, $token));
    }

    public function verificationUrl()
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
