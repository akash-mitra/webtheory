<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'category_id' => null,
        'user_id' => null,
        'title' => $faker->catchPhrase,
        'summary' => $faker->paragraph,
        'metakey' => $faker->word . ',' . $faker->word,
        'metadesc' => $faker->catchPhrase,
        'status' => 'Draft',
    ];
});
