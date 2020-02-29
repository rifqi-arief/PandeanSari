<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PriceModel;
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

$id_product = ProductModel::all()->pluck('id_product');

$factory->define(PriceModel::class, function (Faker $faker) use ($id_product){
    return [
        'id_product' => $faker->randomElement($id_product),
        'price' => $faker->randomNumber,
        'qty' => $faker->name,  
    ];
});
