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


######  OKR  ######
// 顯示個人當季OKR
Route::get('okrs/', 'OKRsController@index')->name('okrs.index');
// 新增個人當季OKR
Route::get('okrs/creat', 'OKRsController@create')->name('okrs.create');
// 儲存個人當季OKR
Route::post('okrs/store', 'OKRsController@store')->name('okrs.store');
Route::post('okrs/store2', 'OKRsController@store2')->name('okrs.store2');
// 編輯個人當季OKR
Route::get('okrs/{objective}/edit', 'OKRsController@edit')->name('okrs.edit');
// 儲存修改好的個人當季OKR
Route::patch('okrs/{objective}/update', 'OKRsController@update')->name('okrs.update');
// 刪除個人當季OKR
Route::delete('okrs/{objective}/destroy', 'OKRsController@destroy')->name('okrs.destroy');
Route::delete('okrs/{keyresult}/destroy2', 'OKRsController@destroy2')->name('okrs.destroy2');
