<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'role' => 'registered',
        'resource' => $faker->randomElement(['categories', 'pages']),
        'action' => $faker->randomElement(['index', 'show', 'store', 'update', 'destroy']),
        'permission' => false,
    ];
});
