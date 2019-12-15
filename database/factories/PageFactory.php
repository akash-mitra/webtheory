<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'category_id' => 1,
        'user_id' => 1,
        'title' => $faker->catchPhrase,
        'summary' => $faker->paragraph,
        'metakey' => $faker->word . ',' . $faker->word,
        'metadesc' => $faker->catchPhrase,
        'media_id' => null,
        'status' => $faker->randomElement(['Draft', 'Live']),
    ];
});
