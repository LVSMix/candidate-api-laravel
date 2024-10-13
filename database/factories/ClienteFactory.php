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
$factory->define(Cliente::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->unique()->numberBetween(1, User::count()),
        'empresa_id' => $faker->unique()->numberBetween(1, Empresa::count()),
        // Rest of attributes...
    ];
});
