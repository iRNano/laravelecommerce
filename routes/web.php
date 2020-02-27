<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::resource('categories', 'CategoryController');
//separate the resource into two, wherein the first one uses the middleware and the second won't use the middleware.
Route::resource('products', 'ProductController',
	["except" => ['show', 'index']])->middleware('isAdmin');
//The routes in this resource except for show and index will use the isAdmin middleware
Route::resource('products', 'ProductController',
	["only" => ['show', 'index']]
); //Use show and index routes only for this resource without a middleware
Route::resource('statuses', 'StatusController');
Route::resource('orders', 'OrderController');
Route::delete('/cart/empty', 'CartController@emptyCart'); //route to empty cart
Route::get('/cart/confirm', 'CartController@confirmOrder'); //route to confirm the order after checkout
Route::resource('cart', 'CartController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
