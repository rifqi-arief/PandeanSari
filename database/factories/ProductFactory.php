<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductModel;
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

$factory->define(ProductModel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        // 'price' => $faker->randomNumber,
        'series' => $faker->unique()->randomNumber,
        'stock' => $faker->randomNumber,
    ];
});
