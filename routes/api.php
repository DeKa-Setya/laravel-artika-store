<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', 'IndexController@index');

Route::post('/register', 'Api\Auth\AuthController@create');
Route::post('/login', 'Api\Auth\AuthController@check');

Route::get('/home',function(){
 return redirect('/dashboard');
});


/*employee*/
// Dashboard
Route::get('dashboard', 'Employee\Dashboard\DashboardController@index');

/*admin*/
// Dashboard
Route::get('dashboard', 'Admin\Dashboard\DashboardController@index');
// input items
Route::post('/inputitem/data', 'Api\Admin\InputItem\InputItemController@showAllData');
//order list
Route::get('orderlist','Api\Admin\OrderList\OrderListController@index');
Route::post('/orderlist/accept','Admin\OrderList\OrderListController@accept');
Route::post('/orderlist/decline','Admin\OrderList\OrderListController@decline');

/*user*/
/*Dashboard*/
Route::get('/dashboard', 'User\Dashboard\DashboardController@index');
Route::post('/dashboard', 'User\Dashboard\DashboardController@store');
Route::post('/dashboard/fetch', 'User\Dashboard\DashboardController@fetch');
Route::post('/dashboard/destroy','User\Dashboard\DashboardController@destroy');
Route::post('/dashboard/add','User\Dashboard\DashboardController@add');
Route::post('/dashboard/remove','User\Dashboard\DashboardController@remove');
/*Order*/
Route::get('/order', 'User\Order\OrderController@index');
Route::post('/order/store', 'User\Order\OrderController@store');
Route::post('/order/district','User\Order\OrderController@getDistrict');
Route::post('/order/subdistrict','User\Order\OrderController@getSubDistrict');
Route::post('/order/village','User\Order\OrderController@getVillage');
Route::post('/order/getdetail','User\Order\OrderController@getdetail');
