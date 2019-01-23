<?php

use Faker\Generator as Faker;

$factory->define(App\Action::class, function (Faker $faker) {
    return [
        'user_id'=> $faker->numberBetween($min = 1, $max = 200),
        'related_kr'=>$faker->numberBetween($min = 1, $max = 800),
        'priority' => $faker->numberBetween($min = 1, $max = 5),
        'title' => $faker->realText($maxNbChars = 30),
        'content' => $faker->realText($maxNbChars = 1020),
        'started_at' => $faker->dateTimeBetween('-1 month', '+1 month'),
        'finished_at' => $faker->dateTimeBetween('+2 month', '+6 month')
    ];
});