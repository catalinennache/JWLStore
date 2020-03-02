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



Route::get('/','ShopController@index')->middleware('RecentlyVW');
Route::get('/shop','ShopController@shop');

Route::get('/cart','ShopController@cart');

//Route::get('/checkout','ShopController@checkout');
Route::get('/billing','ShopController@billing');
Route::post('/checkout','PaymentController@ProcessOrder');
Route::get('/pay','PaymentController@ProcessCheckout')->name('payment.ProcessCheckout');
Route::get('/shops','ShopController@shops')->middleware('RecentlyVW');

Route::get('/about','ShopController@about');

Route::get('/thank','ShopController@thank');
//Route::get('/login','ShopController@login');
//Route::post('/login','ShopController@login_post');

Route::get('/logout','ShopController@logout');
//Route::get('/register','ShopController@register');
Route::get('/delete','ShopController@delete_user');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile',"ProfileController@profile");
Route::get('/order',"ProfileController@ShowOrder");

Route::post('/api/saveProfile',"ProfileController@saveProfile");
Route::post('/api/addtocart',"ShopController@addtocart");
Route::post('/api/removeFromCart',"ShopController@removefromcart");
Route::post('/api/updateCart',"ShopController@updateCart");
Route::get('/fan',"ProfileController@FANTest");
Route::get('/test',"PaymentController@genPDF");
Route::get('/invoice',"PaymentController@showInvoice");
Route::get("/fetchCities","PaymentController@fetchC");
Route::get("/fetchStreets","PaymentController@fetchS");
Route::get('/preparepayment',"PaymentController@PrePay");
Route::get('/email',"PaymentController@testEmail");
Route::get("/inv","PaymentController@inv");
Route::get('/invoiceDownload',"PaymentController@invoiceDownload");
