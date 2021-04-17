<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\View
 *
 * @property int $id
 * @property string $ip
 * @property int|null $user_id
 * @property string $at
 * @property int $date_key
 * @property string $url
 * @property string $content_type
 * @property int $content_id
 * @property string|null $platform
 * @property string|null $browser
 * @property string|null $version
 * @property string|null $referrer
 * @property string|null $referrer_domain
 * @property string $session_id
 * @property string|null $country
 * @property string|null $city
 * @property string|null $latitude
 * @property string|null $longitude
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|View newModelQuery()
 * @method static Builder|View newQuery()
 * @method static Builder|View query()
 * @method static Builder|View whereAt($value)
 * @method static Builder|View whereBrowser($value)
 * @method static Builder|View whereCity($value)
 * @method static Builder|View whereContentId($value)
 * @method static Builder|View whereContentType($value)
 * @method static Builder|View whereCountry($value)
 * @method static Builder|View whereCreatedAt($value)
 * @method static Builder|View whereDateKey($value)
 * @method static Builder|View whereId($value)
 * @method static Builder|View whereIp($value)
 * @method static Builder|View whereLatitude($value)
 * @method static Builder|View whereLongitude($value)
 * @method static Builder|View wherePlatform($value)
 * @method static Builder|View whereReferrer($value)
 * @method static Builder|View whereReferrerDomain($value)
 * @method static Builder|View whereSessionId($value)
 * @method static Builder|View whereUpdatedAt($value)
 * @method static Builder|View whereUrl($value)
 * @method static Builder|View whereUserId($value)
 * @method static Builder|View whereVersion($value)
 * @mixin \Eloquent
 */
class View extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip',
        'user_id',
        'at',
        'date_key',
        'url',
        'content_type',
        'content_id',
        'platform',
        'browser',
        'version',
        'referrer',
        'referrer_domain',
        'session_id',
        'country',
        'city',
        'lat',
        'long',
    ];
}
