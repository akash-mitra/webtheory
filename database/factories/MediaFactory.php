<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker) {
    $filename = $faker->colorName . '.png';
    return [
        'name' => $filename,
        'type' => 'png',
        'size' => rand(10, 50),
        'path' => 'media/' . $filename,
        'url' => '/storage/media/' . $filename,
        'storage' => 'public',
        'user_id' => 1,
    ];
});
