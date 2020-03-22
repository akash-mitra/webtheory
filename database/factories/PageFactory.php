<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    $description = $faker->catchPhrase;

    return [
        'category_id' => 1,
        'user_id' => 1,
        'title' => $description,
        'summary' => $faker->realText() . '.' . $faker->realText(),
        'metakey' => implode(', ', $faker->words($nb = 5, $asText = false)),
        'metadesc' => $description,
        'media_id' => null,
        'status' => $faker->randomElement(['Draft', 'Live']),
    ];
});
