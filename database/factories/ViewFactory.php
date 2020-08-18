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
    $url = $faker->randomElement(['https://google.com', 'https://facebook.com', 'https://instagram.com', 'https://wikipedia.com', null]);
    $viewed_at = $faker->dateTimeBetween($startDate = "-75 days", $endDate = "now");

    return [
        'ip' => $faker->ipv4,
        'user_id' => null,
        'at' => $viewed_at,
        'date_key' => $viewed_at->format('Ymd'),
        // 'url' => env('APP_URL'),
        'content_type' => $faker->randomElement(['App\Page', 'App\Category']),
        // 'content_id' => 1,
        'platform' => $faker->randomElement(['Macintosh', 'Windows', 'Linux', 'iPhone', 'iPad', 'Android', 'Tizen']),
        'browser' => $faker->randomElement(['Safari', 'Firefox', 'Opera Next', 'Chrome', 'Edge', 'IEMobile', 'SamsungBrowser']),
        'version' => $faker->numberBetween($min = 10, $max = 100),
        'referrer' => $url,
        'referrer_domain' => str_ireplace('www.', '', parse_url($url, PHP_URL_HOST)),
        'session_id' => $faker->numberBetween($min = 10, $max = 10000), // $faker->md5,
        'country' => $faker->country,
        'city' => $faker->city,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
