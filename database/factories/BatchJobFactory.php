<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BatchJob;
use Faker\Generator as Faker;

$factory->define(BatchJob::class, function (Faker $faker) {
    
    return [
        'batch_date' => now(),
        'batch_name' => $faker->name,
        'start_datetime' => now(),
        'end_datetime' => now(),
        // 'start_view_id' => $faker->numberBetween($min = 100, $max = 500),
        // 'end_view_id' => $faker->numberBetween($min = 100, $max = 500),
        'status' => $faker->randomElement(['success', 'failed']),
    ];
});
