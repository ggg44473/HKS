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

Route::get('/', ['middleware' => 'guest', function(){ return view('welcome'); }]);

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
// 新增OKR
Route::get('okr/create', 'MyOKRsController@create')->name('okrs.create');
// 儲存OKR
Route::post('okrs/objective/store', 'MyOKRsController@storeObjective')->name('okrs.storeObjective');
Route::post('okrs/kr/store', 'MyOKRsController@storeKR')->name('krs.store');
// 編輯OKR
Route::get('okrs/{objective}/edit', 'MyOKRsController@edit')->name('okrs.edit');
// 儲存修改好的OKR
Route::patch('okrs/{objective}/update', 'MyOKRsController@update')->name('okrs.update');
// 刪除OKR
Route::delete('okrs/{objective}/destroyObjective', 'MyOKRsController@destroyObjective')->name('okrs.destroyObjective');
Route::delete('okrs/{keyresult}/destroyKR', 'MyOKRsController@destroyKR')->name('okrs.destroyKR');


######  個人綜覽  ######
// 顯示個人當季OKR
Route::get('user/{user}/okr', 'MyOKRsController@index')->name('user.index');//UserController
// 顯示個人主頁
Route::get('profile/{user}', 'ProfilesController@index')->name('profile.index');
// 更新個人照片
Route::patch('profile/{user}/update', 'ProfilesController@update')->name('profile.update');

