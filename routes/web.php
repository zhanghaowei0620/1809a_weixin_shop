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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::any('cateInfo','Index\IndexController@cateInfo');
Route::any('goodsList','Index\IndexController@goodsList');
Route::any('goodsCart','Index\IndexController@goodsCart');
Route::any('listCart','Index\IndexController@listCart');
Route::any('cartList','Index\OrderController@cartList');
Route::any('cartshow','Index\OrderController@cartshow');




