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

Route::group(['middleware' => 'loginFalse'], function () {
	Route::get('/register','LoginController@register')->name('web.register');
	Route::get('/login','LoginController@login')->name('web.login');

	Route::get('/register/check','LoginController@registerCheck')->name('web.register.registerCheck');//提交注册
	Route::get('/register/isExistence','LoginController@isExistence')->name('web.register.isExistence');//检测用户名\email是否存在
	Route::get('/login/check','LoginController@loginValidate')->name('web.login.loginCheck');//检测用户名\email是否存在
});

Route::group(['middleware' => 'loginTrue'], function () {
	Route::get('/','IndexController@index')->name('web.index');

	Route::prefix('project')->group(function($route){
		$route->get('/create','ProjectController@projectCreate')->name('web.create');
		$route->get('/list','ProjectController@projectList')->name('web.project.list');
	});
});

