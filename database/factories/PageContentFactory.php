<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PageContent;
use Faker\Generator as Faker;

$factory->define(PageContent::class, function (Faker $faker) {
    return [
        'page_id' => null,
        'body_json' => '{"blocks":[{"type":"header","data":{"level":1,"text":"' . $faker->sentence . '"}},{"type":"paragraph","data":{"text":"' . $faker->paragraph . '"}}]}',
        'body_html' => $faker->paragraph,
    ];
});
