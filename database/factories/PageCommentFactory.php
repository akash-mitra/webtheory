<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PageComment;
use Faker\Generator as Faker;

$factory->define(PageComment::class, function (Faker $faker) {
    return [
        'parent_id' => null,
        'reference_id' => 1,
        'user_id' => 1,
        'body' => $faker->paragraph,
        'likes' => $faker->numberBetween($min = 100, $max = 500),
        'dislikes' => $faker->numberBetween($min = 100, $max = 200),
    ];
});
