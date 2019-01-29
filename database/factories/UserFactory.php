<?php

use Faker\Generator as Faker;

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'), // secret
        'position' => $faker->realText($maxNbChars = 10),
        'company_id' => 1,
    ];
});

$factory->define(App\Permission::class, function (Faker $faker) {
    return[
        'model_type' => App\Company::class,
        'model_id' => 1,
        'role_id' => 4,
    ];
});
