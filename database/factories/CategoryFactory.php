<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $description = $faker->catchPhrase;

    return [
        'name' => $faker->unique()->colorName,
        'parent_id' => null,
        'description' => $description,
        'metakey' => implode(', ', $faker->words($nb = 5, $asText = false)),
        'metadesc' => $description,
        'media_id' => null,
        'user_id' => 1,
    ];
});
