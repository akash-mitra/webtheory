<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Form;
use Faker\Generator as Faker;

$factory->define(Form::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->catchPhrase,
        'status' => $faker->randomElement(['Draft', 'Live']),
        'captcha' => $faker->randomElement([true, false]),
        'fields' => '[{"name": "name","type": "text","desc": "Provide your name","placeholder": "Harry Potter","validation": "min:2|max:100","default": "","options": []},{"name": "email","type": "email","desc": "Provide a valid email id.","placeholder": "harry.potter@example.com","validation": "email","default": "","options": []}]',
    ];
});
