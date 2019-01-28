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

/*

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/

Route::get('/', 'IndexController@index');

Auth::routes();

Route::get('/home',function(){
 return redirect('/dashboard');
});


Route::prefix('employee')->group(function(){
    // Dashboard
    Route::get('dashboard', 'Employee\Dashboard\DashboardController@index');
});

Route::prefix('admin')->group(function(){
    // Dashboard
    Route::get('dashboard', 'Admin\Dashboard\DashboardController@index');
    // input items
    Route::resource('inputitem', 'Admin\Item\InputItemController');
    //order list
    Route::resource('orderlist','Admin\OrderList\OrderListController');
});
Route::get('/dashboard', 'User\Dashboard\DashboardController@index');
Route::post('/dashboard', 'User\Dashboard\DashboardController@store');
Route::post('/dashboard/fetch', 'User\Dashboard\DashboardController@fetch');
Route::post('/dashboard/destroy','User\Dashboard\DashboardController@destroy');
Route::post('/dashboard/add','User\Dashboard\DashboardController@add');
Route::post('/dashboard/remove','User\Dashboard\DashboardController@remove');
//
Route::get('/order', 'User\Order\OrderController@index');
Route::post('/order/store', 'User\Order\OrderController@store');
Route::post('/order/district','User\Order\OrderController@getDistrict');
Route::post('/order/subdistrict','User\Order\OrderController@getSubDistrict');
Route::post('/order/village','User\Order\OrderController@getVillage');
Route::post('/order/getdetail','User\Order\OrderController@getdetail');

//
//Route::post('/order', 'User\Dashboard\CartController@index');
