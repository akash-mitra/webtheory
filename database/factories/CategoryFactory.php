<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    // static $id = 0;
    return [
        // 'id' => $id++,
        'name' => $faker->colorName,
        'parent_id' => null,
        'description' => $faker->catchPhrase,
        'metakey' => $faker->word . ',' . $faker->word,
        'metadesc' => $faker->catchPhrase,
        'media_id' => null,
        'user_id' => 1,
    ];
});
