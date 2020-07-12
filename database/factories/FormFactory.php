<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Form;
use Faker\Generator as Faker;

$factory->define(Form::class, function (Faker $faker) {
    $fields = [
        [
            'name' => 'name',
            'type' => 'text',
            'desc' => 'Provide your name',
            'placeholder' => 'Harry Potter',
            'validation' => 'min" =>2|max" =>100',
            'default' => '',
            'options' => [],
        ],
        [
            'name' => 'email',
            'type' => 'email',
            'desc' => 'Provide a valid email id.',
            'placeholder' => 'harry.potter@example.com',
            'validation' => 'email',
            'default' => '',
            'options' => [],
        ],
        [
            'name' => 'address',
            'type' => 'textbox',
            'desc' => 'Contact Address',
            'placeholder' => '4 Privet Drive, Surrey, UK',
            'validation' => '',
            'default' => '',
            'options' => [],
        ],
        [
            'name' => 'magic_house',
            'type' => 'radio',
            'desc' => 'Which Hogwarts House do you belong?',
            'placeholder' => 'Gryffindor',
            'validation' => '',
            'default' => 'Gryffindor',
            'options' => ['Hufflepuff', 'Ravenclaw', 'Gryffindor', 'Slytherin'],
        ],
        [
            'name' => 'mentor',
            'type' => 'select',
            'desc' => 'Best defence against the dark art teacher',
            'placeholder' => 'Dumbledor',
            'validation' => '',
            'default' => '',
            'options' => ['Dumbledor', 'Severus Snape', 'Remus Lupin', 'Mad-eye Moody'],
        ],
        [
            'name' => 'friends',
            'type' => 'multiselect',
            'desc' => '',
            'placeholder' => 'Friends versus enemies',
            'validation' => '',
            'default' => '',
            'options' => ['Ron Weasley', 'Hermione', 'Neville Longbottom', 'Lucious Malfoy'],
        ],
    ];

    return [
        'name' => $faker->name,
        'description' => $faker->catchPhrase,
        'status' => $faker->randomElement(['Draft', 'Live']),
        'captcha' => $faker->randomElement([true, false]),
        'fields' => $fields,
    ];
});
