<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
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
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'role' => 'guest',
        'avatar' => 'https://i.pravatar.cc/100?u=' . $fakeEmail,
        'about_me' => $faker->paragraph(),
        'gender' => $faker->randomElement($array = [true, false]),
        'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'preferences' => ["broadcast","database","mail"],
        'stripe_id' => $faker->uuid,
        'card_brand' => $faker->creditCardType,
        'card_last_four' => $faker->numberBetween($min = 1000, $max = 9000),
        'trial_ends_at' => $faker->dateTimeBetween($startDate = "now", $endDate = "30 days"),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
