<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Template;
use Faker\Generator as Faker;

$factory->define(Template::class, function (Faker $faker) {
    return [
        'name'=> Str::random(),
        'description' => Str::random(),
        'active' => 0,
        'user_id' => 1
    ];
});
