<?php

use Faker\Generator as Faker;

$factory->define(App\Objective::class, function (Faker $faker) {
    return [
        'title'=>$faker->realText($maxNbChars = 15),
        'model_id' => $faker->numberBetween($min = 1, $max = 4),
        'model_type' => 'App\User',
        'started_at' => $faker->dateTimeBetween('-1 month', '+1 month'),
        'finished_at' => $faker->dateTimeBetween('+2 month', '+6 month')
    ];
});
