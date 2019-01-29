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

Route::get('/', ['middleware' => 'guest', function () {
    return view('welcome');
}]);

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {

    # 個人行事曆
    // Route::resource('events','EventController');
    Route::get('calendar', 'ActivityController@calendar')->name('calendar.index');
    Route::post('calendar/user/{user}/create', 'ActivityController@create')->name('calendar.create');
    Route::get('calendar/activity/{activity}/show', 'ActivityController@show')->name('calendar.show');
    Route::patch('calendar/activity/{activity}/update', 'ActivityController@update')->name('calendar.update');
    Route::delete('calendar/activity/{activity}/destroy', 'ActivityController@destroy')->name('calendar.destroy');

    # 搜尋
    Route::get('search', 'SearchController@index')->name('search.index');

    # 個人綜覽
    // 顯示個人OKR
    Route::get('user/{user}/okr', 'UserController@listOKR')->name('user.okr');
    // 顯示個人Action
    Route::get('user/{user}/action', 'UserController@listAction')->name('user.action');
    // 顯示個人帳號設定
    Route::get('user/{user}', 'UserController@settings')->name('user.settings');
    // 更新個人照片
    Route::patch('user/{user}/update', 'UserController@update')->name('user.update');
    // 新增個人O
    Route::post('user/{user}/objective/store', 'UserController@storeObjective')->name('user.objective.store');

    # OKR
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

    # Action
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
    Route::get('actions/{action}/show', 'ActionsController@show')->where('action', '[0-9]+')->name('actions.show');
    //刪除個人Action
    Route::delete('actions/{action}/destroy', 'ActionsController@destroy')->name('actions.destroy');
    //刪除Action的檔案
    Route::get('actions/{action}/media/{media}/destroy', 'ActionsController@destroyFile')->name('actions.destroyFile');
    //回傳search
    Route::get('objective/{objective}/action/user/search', 'ActionsController@search')->name('actions.user.search');
    //拒絕邀請
    Route::get('actions/{action}/member/{member}/invite/reject', 'ActionsController@rejectInvite')->name('actions.member.invite.reject');
    //同意邀請
    Route::get('actions/{action}/member/{member}/invite/agree', 'ActionsController@agreeInvite')->name('actions.member.invite.agree');

    # 組織OKR
    //組織OKR首頁
    Route::get('organization', 'CompanyController@index')->name('company.index');
    //新增公司
    Route::post('organization/company/store', 'CompanyController@store')->name('company.store');
    //編輯公司頁面
    Route::get('organization/company/edit', 'CompanyController@edit')->name('company.edit');
    //更新公司
    Route::patch('organization/company/update', 'CompanyController@update')->name('company.update');
    //刪除公司
    Route::delete('organization/company/destroy', 'CompanyController@destroy')->name('company.destroy');
    //顯示公司OKR
    Route::get('organization/company/okr', 'CompanyController@listOKR')->name('company.okr');
    //公司新增O
    Route::post('organization/company/{company}/objective/store', 'CompanyController@storeObjective')->name('company.objective.store');
    //公司成員頁面
    Route::get('organization/company/member', 'CompanyController@member')->name('company.member');
    //發送邀請
    Route::post('organization/company/{company}/member/invite', 'CompanyController@inviteMember')->name('company.member.invite');
    //取消邀請
    Route::patch('organization/company/{company}/member/{member}/invite/destroy', 'CompanyController@cancelInvite')->name('company.member.invite.destroy');
    //拒絕邀請
    Route::get('organization/company/{company}/member/{member}/invite/reject', 'CompanyController@rejectInvite')->name('company.member.invite.reject');
    //同意邀請
    Route::get('organization/company/{company}/member/{member}/invite/agree', 'CompanyController@agreeInvite')->name('company.member.invite.agree');
    //更新公司成員
    Route::patch('organization/company/member/update', 'CompanyController@updateMember')->name('company.member.update');
    //刪除公司成員
    Route::patch('organization/company/member/{member}/destroy', 'CompanyController@destroyMember')->name('company.member.destroy');

    //顯示子部門頁面
    Route::get('organization/department/{department}', 'DepartmentController@index')->name('department.index');
    //儲存新增部門
    Route::post('organization/department/store', 'DepartmentController@store')->name('department.store');
    //編輯部門頁面
    Route::get('organization/department/{department}/edit', 'DepartmentController@edit')->name('department.edit');
    //更新公司
    Route::patch('organization/department/{department}/update', 'DepartmentController@update')->name('department.update');
    //刪除部門
    Route::delete('organization/department/{department}/destroy', 'DepartmentController@destroy')->name('department.destroy');
    //顯示部門OKR
    Route::get('organization/department/{department}/okr', 'DepartmentController@listOKR')->name('department.okr');
    //部門新增O
    Route::post('organization/department/{department}/objective/store', 'DepartmentController@storeObjective')->name('department.objective.store');
    //部門成員頁面
    Route::get('organization/department/{department}/member', 'DepartmentController@member')->name('department.member');
    //部門成員設定頁面
    Route::get('organization/department/{department}/member/setting', 'DepartmentController@memberSetting')->name('department.member.setting');
    //新增部門成員
    Route::post('organization/department/{department}/member/store', 'DepartmentController@storeMember')->name('department.member.store');
    //更新部門成員
    Route::patch('organization/department/{department}/member/update', 'DepartmentController@updateMember')->name('department.member.update');
    //刪除部門成員
    Route::patch('organization/department/{department}/member/{member}/destroy', 'DepartmentController@destroyMember')->name('department.member.destroy');

    # Project
    //專案首頁
    Route::get('project', 'ProjectController@index')->name('project');
    //儲存新增專案
    Route::post('project/store', 'ProjectController@store')->name('project.store');
    //更新專案
    Route::patch('project/{project}/update', 'ProjectController@update')->name('project.update');
    //完成專案
    Route::get('project/{project}/done', 'ProjectController@done')->name('project.done');
    //刪除專案
    Route::delete('project/{project}/destroy', 'ProjectController@destroy')->name('project.destroy');
    //顯示專案OKR
    Route::get('project/{project}/okr', 'ProjectController@listOKR')->name('project.okr');
    //專案新增O
    Route::post('project/{project}/objective/store', 'ProjectController@storeObjective')->name('project.objective.store');
    //專案成員頁面
    Route::get('project/{project}/member', 'ProjectController@member')->name('project.member');
    //發送邀請
    Route::post('project/{project}/member/invite', 'ProjectController@inviteMember')->name('project.member.invite');
    //取消邀請
    Route::patch('project/{project}/member/{member}/invite/destroy', 'ProjectController@cancelInvite')->name('project.member.invite.destroy');
    //拒絕邀請
    Route::get('project/{project}/member/{member}/invite/reject', 'ProjectController@rejectInvite')->name('project.member.invite.reject');
    //同意邀請
    Route::get('project/{project}/member/{member}/invite/agree', 'ProjectController@agreeInvite')->name('project.member.invite.agree');
    //更新專案成員
    Route::patch('project/{project}/member/update', 'ProjectController@updateMember')->name('project.member.update');
    //刪除專案成員
    Route::patch('project/{project}/member/{member}/destroy', 'ProjectController@destroyMember')->name('project.member.destroy');

    //回傳未有公司的使用者
    Route::get('search/member/nonCompany/', 'CompanyController@search')->name('company.member.search');
    //回傳無部門的公司成員
    Route::get('search/company/{company}/member/nonDepartment/', 'DepartmentController@search')->name('department.member.search');
    //回傳不屬於此專案的公司成員
    Route::get('search/company/member/project/{project}', 'ProjectController@search')->name('project.member.search');

    # 追蹤
    //專案首頁
    Route::get('follow', 'FollowController@index')->name('follow.index');
    //追蹤
    Route::get('follow/{type}/{owner}', 'FollowController@follow')->name('follow');
    //取消追蹤
    Route::get('follow/{type}/{owner}/cancel', 'FollowController@cancel')->name('follow.cancel');

    # 留言
    Route::post('comments/{comment}', 'CommentsReplyController@reply');
});
