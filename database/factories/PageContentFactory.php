<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PageContent;
use Faker\Generator as Faker;

$factory->define(PageContent::class, function (Faker $faker) {
    return [
        'page_id' => null,
        'body_json' => $faker->paragraph,
        'body_html' => $faker->paragraph,
    ];
});
