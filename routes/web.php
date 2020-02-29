<?php

use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/add-category', "CategoryController@addCategory");
$router->post('/edit-category', "CategoryController@editCategory");
$router->post('/delete-category', "CategoryController@deleteCategory");
$router->post('/get-category', "CategoryController@getCategory"); 

$router->post('/add-product', "ProductController@addProduct");
$router->post('/edit-product', "ProductController@editProduct");
$router->post('/edit-price', "ProductController@editPrice");
$router->post('/delete-product', "ProductController@deleteProduct");

$router->post('/search', "SearchController@search");
$router->post('/compare', "CompareController@compare");

$router->post('/add-transaction', "TransactionController@addTransaction");
$router->post('/get-transaction', "TransactionController@getTransaction");
