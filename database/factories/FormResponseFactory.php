<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FormResponse;
use Faker\Generator as Faker;

$factory->define(FormResponse::class, function (Faker $faker) {
    return [
        // 'form_id' => 1,
        'ip' => $faker->ipv4,
        'responses' => '["' . $faker->name . '","' . $faker->email . '"]',
    ];
});
