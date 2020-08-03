<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PageContent;
use Faker\Generator as Faker;

$factory->define(PageContent::class, function (Faker $faker) {
    $heading = $faker->realText(40);
    $paragraph = $faker->realText() . '.' . $faker->realText();

    return [
        'page_id' => null,
        'body_json' => '{"blocks":[{"type":"header","data":{"level":1,"text":"' . $heading . '"}},{"type":"paragraph","data":{"text":"' . $paragraph . '"}}]}',
        'body_html' => '<h1>' . $heading . '</h1>' . '<p>' . $paragraph . '</p>',
        'type' => 'editorjs',
        'display_order' => 1,
    ];
});
