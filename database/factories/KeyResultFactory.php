<?php

use Faker\Generator as Faker;

$factory->define(App\KeyResult::class, function (Faker $faker) {
    return [
        'objective_id'=> $faker->numberBetween($min = 1, $max = 12),
        'title'=>$faker->realText($maxNbChars = 30),
        'confidence' => $faker->numberBetween($min = 0, $max = 10),
        'initial_value' => $faker->numberBetween($min = 0, $max = 10),
        'target_value' => $faker->numberBetween($min = 11, $max = 20),
        'current_value' => $faker->numberBetween($min = 0, $max = 20),
        'weight' => $faker->numberBetween($min = 0, $max = 3),
    ];
});
