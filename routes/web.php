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

Auth::routes();

// #登入
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login');

// #登出
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// #註冊
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register')->name('register.post');

// #忘記密碼
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');

######  個人綜覽  ######
// 顯示個人OKR
Route::get('user/{user}/okr', 'UserController@listOKR')->name('user.okr');
// 顯示個人帳號設定
Route::get('user/{user}', 'UserController@settings')->name('user.settings');
// 更新個人照片
Route::patch('user/{user}/update', 'UserController@update')->name('user.update');

######  OKR  ######
// 新增O頁面
Route::get('objective/create', 'ObjectiveController@create')->name('objective.create');
// 儲存O
Route::post('objective/store/{type}', 'ObjectiveController@store')->name('objective.store');
// 刪除O
Route::delete('objective/{objective}/destroy', 'ObjectiveController@destroy')->name('objective.destroy');

// 編輯OKR頁面
Route::get('okr/{objective}/edit', 'OkrController@edit')->name('okr.edit');
// 更新修改好的OKR
Route::patch('okr/{objective}/update', 'OkrController@update')->name('okr.update');

// 儲存KR
Route::post('kr/store', 'KrController@store')->name('kr.store');
// 刪除KR
Route::delete('kr/{keyresult}/destroy', 'KrController@destroy')->name('kr.destroy');

###### Action ######
// 新增Action頁面
Route::get('objective/{objective}/action/create', 'ActionsController@create')->name('actions.create');
// 儲存Action
Route::post('actions/store', 'ActionsController@store')->name('actions.store');
// 完成Action
Route::post('actions/{action}/done', 'ActionsController@done')->name('actions.done');
// 編輯Action頁面
Route::get('actions/{action}/edit', 'ActionsController@edit')->name('actions.edit');
// 更新Action
Route::patch('actions/{action}/update', 'ActionsController@update')->name('actions.update');
// 顯示指定的Action
Route::get('actions/{action}/show','ActionsController@show')->where('action','[0-9]+')->name('actions.show');
//刪除個人Action
Route::delete('actions/{action}/destroy', 'ActionsController@destroy')->name('actions.destroy');


//下載上傳的檔案
Route::get('file/{file}/actions/{post_id}', 'ActionsController@download')->name('download');
//顯示上傳圖片
Route::get('img/{file_path}', 'ActionsController@getImg')->name('img');
//刪除檔案
Route::get('actions/{action}/destroyFile/{file_path}', 'ActionsController@destroyFile')->name('actions.destroyFile');


###### 組織OKR ######
//組織OKR首頁
Route::get('organization', 'OrganizationController@index')->name('organization');
//新增公司
Route::post('organization/company/store', 'CompanyController@store')->name('company.store');
//新增部門頁面
Route::get('organization/department/create', 'DepartmentController@create')->name('department.create');
//顯示公司OKR
Route::get('organization/company/okr', 'CompanyController@listOKR')->name('company.okr');