<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FormResponse;
use Faker\Generator as Faker;

$factory->define(FormResponse::class, function (Faker $faker) {
    $formresponses = [
        'name' => $faker->name,
        'email' => $faker->email,
        'address' => $faker->streetAddress,
        'magic_house' => $faker->randomElement($array = ['Hufflepuff', 'Ravenclaw', 'Gryffindor', 'Slytherin']),
        'mentor' => $faker->randomElement($array = ['Dumbledor', 'Severus Snape', 'Remus Lupin', 'Mad-eye Moody']),
        'friends' => $faker->randomElement($array = ['Ron Weasley', 'Hermione', 'Neville Longbottom', 'Lucious Malfoy']),
    ];

    return [
        // 'form_id' => 1,
        'ip' => $faker->ipv4,
        'responses' => json_encode($formresponses),
    ];
});
