<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CategoryComment;
use Faker\Generator as Faker;

$factory->define(CategoryComment::class, function (Faker $faker) {
    return [
        'parent_id' => null,
        'reference_id' => 1,
        'user_id' => 1,
        'body' => $faker->realText(),
        'likes' => $faker->numberBetween($min = 100, $max = 500),
        'dislikes' => $faker->numberBetween($min = 100, $max = 200),
    ];
});
