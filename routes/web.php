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

Route::get('/', 'WelcomeController@index');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

#登入
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

#登出
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

#註冊
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register.post');

#忘記密碼
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


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
