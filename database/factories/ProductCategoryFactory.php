<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductCategoryModel;
use App\CategoryModel;
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
$id_category = CategoryModel::all()->pluck('id_category');

$factory->define(ProductCategoryModel::class, function (Faker $faker) use ($id_product,$id_category) {
    return [
        'id_product' => $faker->randomElement($id_product),
        'id_category' => $faker->randomElement($id_category),
    ];
});
