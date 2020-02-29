<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CategoryModel;
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

$factory->define(CategoryModel::class, function (Faker $faker) {
    return [
        'id_parent_category' => $faker->numberBetween($min = 1, $max = 10),
        'name' => $faker->name,
    ];
});
