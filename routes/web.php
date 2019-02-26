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

Route::get('/logout','Auth\LoginController@logout');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    Route::get('/home', 'HomeController@index')->name('home');

    //Dashboard Related Routed
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/checkoutTable/{id}', 'HomeController@checkoutTable')->name('checkoutTable');
    Route::get('/editorder/{id}', 'HomeController@editOrder')->name('editorder');
    Route::get('/show/{id}','HomeController@showupdateform')->name('show');
    Route::post('/updateorder','HomeController@updateOrder')->name('updateorder');
    Route::get('/deleteOrder/{id}', 'HomeController@deleteOrder')->name('deleteOrder');
    Route::get('/changetablestatus/{id}','HomeController@changetablestatus')->name('changetablestatus');
    
    Route::get('/viewtransaction','HomeController@viewtransaction');


    /*User realted routes*/
    Route::get('/user', 'UserController@index')->name('user.index');
    Route::post('/user', 'UserController@store')->name('user.store');
    Route::get('/user/edit/{id}', 'UserController@edit')->name('user.edit');
    Route::patch('/user/edit/{id}', 'UserController@update')->name('user.update');

    /*Category related routes*/
    Route::get('/category', 'CategoryController@index')->name('category.index');
    Route::post('/category', 'CategoryController@store')->name('category.store');
    Route::get('/category/edit/{id}', 'CategoryController@edit')->name('category.edit');
    Route::patch('/category/edit/{id}', 'CategoryController@update')->name('category.update');

    /*Menu related routes*/
    Route::get('/menu', 'MenuController@index')->name('menu.index');
    Route::post('/menu', 'MenuController@store')->name('menu.store');
    Route::get('/menu/edit/{id}', 'MenuController@edit')->name('menu.edit');
    Route::patch('/menu/edit/{id}', 'MenuController@update')->name('menu.update');

    /*Stock  related routes*/
    Route::get('/stock', 'StockController@index')->name('stock.index');
    Route::post('/stock', 'StockController@store')->name('stock.store');

    /*Table Related routes*/
    Route::get('/table', 'TableController@index')->name('table.index');
    Route::post('/table', 'TableController@store')->name('table.store');
    Route::get('/table/edit/{id}', 'TableController@edit')->name('table.edit');
    Route::patch('/table/edit/{id}', 'TableController@update')->name('table.update');

    /*Report related routes*/
    Route::get('/report', 'RecordController@index')->name('record.index');
    Route::post('/search', 'RecordController@search')->name('record.search');
    Route::get('/stockreport', 'StockController@report')->name('stock.report');
    Route::post('/stocksearch', 'StockController@search')->name('stock.search');
});


/*Print From thermal printer*/
Route::get('/printkot', 'PrintController@printTest')->name('printkot');
Route::get('/printbot', 'PrintController@printTest2')->name('printbot');

Route::get('/view_bill', function(){
    return view('test_view');
});
Route::get('/test/chart','DateTimeController@chartdata');

Route::get('/datetime','DateTimeController@showdatetime');
Route::post('/viewreport','DateTimeController@viewreport')->name('viewreport');
Route::get('/savetoexcel','RecordController@savetoexcel')->name('savetoexcel');

// route for move table 
Route::post('/movetable/{origin}','HomeController@movetable')->name('movetable');

//route for ajax post 
Route::get('/ajaxpost','DateTimeController@showajaxpostform');

Route::post('/ajaxpost','DateTimeController@ajaxpost');

Route::get('/{locale}', function ($locale) {
    App::setLocale($locale);
return view('lang');
});