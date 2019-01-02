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
Route::get('okrs/', 'MyOKRsController@index')->name('okrs.index');
// 新增個人當季OKR
Route::get('okrs/creat', 'MyOKRsController@create')->name('okrs.create');
// 儲存個人當季OKR
Route::post('okrs/storeObjective', 'MyOKRsController@storeObjective')->name('okrs.storeObjective');
Route::post('okrs/storeKR', 'MyOKRsController@storeKR')->name('okrs.storeKR');
// 編輯個人當季OKR
Route::get('okrs/{objective}/edit', 'MyOKRsController@edit')->name('okrs.edit');
// 儲存修改好的個人當季OKR
Route::patch('okrs/{objective}/update', 'MyOKRsController@update')->name('okrs.update');
// 刪除個人當季OKR
Route::delete('okrs/{objective}/destroyObjective', 'MyOKRsController@destroyObjective')->name('okrs.destroyObjective');
Route::delete('okrs/{keyresult}/destroyKR', 'MyOKRsController@destroyKR')->name('okrs.destroyKR');
