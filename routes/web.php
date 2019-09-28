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

Route::get('/', function () {
    return view('home');
});
Route::get('/shop','ShopController@shop');

Route::get('/cart','ShopController@cart');

Route::get('/checkout','ShopController@checkout');

Route::get('/shops','ShopController@shops');

Route::get('/about','ShopController@about');

Route::get('/thank','ShopController@thank');
Route::get('/login','ShopController@login');

Route::get('/register','ShopController@register');

