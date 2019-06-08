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

Route::get('/', 'HomeController@index');

Route::get('member', 'MemberController@index')->middleware('auth');

Route::get('project', 'ProjectController@index')->middleware('auth');

Route::get('avatars/{file}', 'MemberController@getAvatar')->middleware('auth');

Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax', 'middleware' => 'auth'], function () {
	
	Route::resource('member', 'MemberController');

	Route::post('updateMember/{id}', 'MemberController@update');
	
	Route::resource('project', 'ProjectController');

	Route::get('detailProject/{id}', 'ProjectController@detailProject');

	Route::resource('user_role', 'UserRoleController');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
