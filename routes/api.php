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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Login
Route::post('/login','APIController@login');
Route::get('/tables','APIController@getTables');
Route::get('/menus', 'APIController@getMenus');
Route::get('/categories', 'APIController@getCategories');

//updated api for get order
Route::get('/order/{id}','APIController@getOrder');

Route::post('/order', 'APIController@postOrder');
Route::post('/checkout', 'APIController@postCheckout');

//updated
Route::get('/tabledetails/{id}','APIController@tabledetails');
Route::post('/changedeliverstatus','APIController@changedeliverstatus');

Route::post('/ajaxpost','DateTimeController@ajaxpost');