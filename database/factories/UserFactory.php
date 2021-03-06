<?php

/** @var Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

    $fakeEmail = $faker->unique()->safeEmail;

    return [
        'name' => $faker->name,
        'email' => $fakeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'remember_token' => Str::random(10),
        'role' => 'guest',
        'avatar' => 'https://s3-ap-southeast-1.amazonaws.com/pravatar.cc/' . rand(1, 36) . '.jpg',
        'about_me' => $faker->paragraph(),
        'gender' => $faker->randomElement(['Male', 'Female']),
        'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'profile' => null,
        'preferences' => ["broadcast", "database", "mail"],
        'stripe_id' => $faker->uuid,
        'card_brand' => $faker->creditCardType,
        'card_last_four' => $faker->numberBetween($min = 1000, $max = 9000),
        'trial_ends_at' => $faker->dateTimeBetween($startDate = "now", $endDate = "30 days"),
        'created_at' => now(),
        'updated_at' => now(),
        'public_id' => Str::random(30),
    ];
});
