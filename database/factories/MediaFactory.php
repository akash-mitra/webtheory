<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker) {
    $fileExtension = $faker->randomElement(['jpeg', 'png', 'bmp', 'gif', 'svg', 'webp']);
    $filename = $faker->domainWord . '.' . $fileExtension;
    
    return [
        'name' => $filename,
        'type' => $fileExtension,
        'size' => rand(10, 50),
        'path' => 'media/' . $filename,
        'url' => '/storage/media/' . $filename,
        'storage' => 'public',
        'user_id' => 1,
    ];
});
