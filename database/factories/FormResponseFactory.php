<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FormResponse;
use Faker\Generator as Faker;

$factory->define(FormResponse::class, function (Faker $faker) {
    $formresponses = [
        'name' => $faker->name,
        'email' => $faker->email,
        'address' => $faker->streetAddress,
        'magic_house' => $faker->randomElement(['Hufflepuff', 'Ravenclaw', 'Gryffindor', 'Slytherin']),
        'mentor' => $faker->randomElement(['Dumbledor', 'Severus Snape', 'Remus Lupin', 'Mad-eye Moody']),
        'friends' => $faker->randomElement(['Ron Weasley', 'Hermione', 'Neville Longbottom', 'Lucious Malfoy']),
        'score' => $faker->numberBetween($min = 6, $max = 10),
    ];

    return [
        // 'form_id' => 1,
        'ip' => $faker->ipv4,
        'responses' => json_encode($formresponses),
    ];
});
