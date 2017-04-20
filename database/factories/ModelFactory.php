<?php

use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'role_id' => $faker->numberBetween(1,3),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = Hash::make('123456', ['rounds' => 15]),
        'remember_token' => str_random(10),
        'created_at' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now'),
    ];
});

$factory->define(App\County::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name
    ];
});

$factory->define(App\Apartment::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Apartman ' . $faker->name,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'county_id' => function () {
            return factory(App\County::class)->create()->id;
        },
        'stars' => $faker->numberBetween(1,5),
        'description' => $faker->text(150),
        'price' => $faker->numberBetween(1, 2000),
        'active_until' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 months'),
        'created_at' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now'),
    ];
});


