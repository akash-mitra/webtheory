<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Menu;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
    $description = $faker->catchPhrase;

    return [
        'title' => $faker->unique()->colorName,
        'alias' => null,
        'parent_id' => null,
        'sequence_num' => 1,
        // 'menuable_id' => 1,
        // 'menuable_type' => 'App/Category',
        'home' => 0,
    ];
});
