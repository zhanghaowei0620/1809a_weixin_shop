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

Route::any('xmladd','Weixin\WeixinController@xmladd');
Route::any('accessToken','Weixin\WeixinController@accessToken');

Route::any('cateInfo','Index\IndexController@cateInfo');
Route::any('goodsList','Index\IndexController@goodsList');
Route::any('goodsCart','Index\IndexController@goodsCart');
Route::any('listCart','Index\IndexController@listCart');
Route::any('cartList','Index\OrderController@cartList');
Route::any('cartshow','Index\OrderController@cartshow');
Route::any('goodssort','Index\IndexController@goodssort');
Route::any('goodshistory','Index\IndexController@goodshistory');
Route::any('createadd','Weixin\WeixinController@createadd');
Route::any('openiddo','Weixin\WeixinController@openiddo');

Route::any('wpay','Weixin\WeixinController@wpay');
Route::any('arr2Xml','Weixin\WeixinController@arr2Xml');
Route::any('notify','Weixin\WeixinController@notify');
Route::any('wstatus','Weixin\WeixinController@wstatus');
Route::any('paySuccess','Weixin\WeixinController@paySuccess');
Route::any('jsdemo','Weixin\JssdkController@jsdemo');

Route::get('getImg', 'Weixin\JssdkController@getImg');


Route::any('delorder','Weixin\CrontabController@delorder');
Route::any('wechat','Weixin\WeixinController@wechat');
Route::any('wechatToken','Weixin\WeixinController@wechatToken');



