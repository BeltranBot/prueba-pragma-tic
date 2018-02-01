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
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'nit' => $faker->numberBetween(1000000000, 9999999999),
        'name' => $faker->company,
        'phone' => $faker->numberBetween(1000000, 9999999),
        'address' => $faker->address,
        'email' => $faker->email,
    ];
});

$factory->define(App\Printer::class, function (Faker $faker) {
    return [
        'model' => $faker->username,
        'prep_time' => $faker->randomFloat(null, 0.16, 1.00),
        'max_width' => $faker->randomFloat(null, 2.00, 30.00),
        'printing_speed' => $faker->randomFloat(null, 60.00, 200.00),
    ];
});

$factory->define(App\Paper::class, function (Faker $faker) {
    return [
        'name' => $faker->username,
    ];
});

$factory->define(App\Operator::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'hour_cost' => $faker->numberBetween(10000, 50000),
    ];
});
