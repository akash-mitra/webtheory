<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\View;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(View::class, function (Faker $faker) {

    $fakeEmail = $faker->unique()->safeEmail;
    $url = $faker->randomElement($array = [$faker->url, env('APP_URL'), null]);

    return [
        'ip' => $faker->ipv4,
        'user_id' => null,
        'at' => $faker->unixTime($faker->dateTimeBetween($startDate = "-60 days", $endDate = "now")),
        // 'url' => env('APP_URL'),
        'content_type' => 'App\Page',
        // 'content_id' => 1,
        'platform' => $faker->randomElement($array = ['Macintosh', 'Windows', 'Linux', 'iPhone', 'Android']),
        'browser' => $faker->randomElement($array = ['Safari', 'Firefox', 'Opera Next', 'Chrome', 'Edge']),
        'version' => $faker->numberBetween($min = 10, $max = 100),
        'referrer' => $url,
        'referrer_domain' => str_ireplace('www.', '', parse_url($url, PHP_URL_HOST)),
        'session_id' => $faker->numberBetween($min = 10, $max = 30), // $faker->md5,
        'country' => $faker->country,
        'city' => $faker->city,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
