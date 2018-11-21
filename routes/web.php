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

	Route::get('/register/check','LoginController@registerCheck')->name('web.register.registerCheck');
	Route::get('/register/isExistence','LoginController@isExistence')->name('web.register.isExistence');
	Route::get('/login/check','LoginController@loginValidate')->name('web.login.loginCheck');
});

Route::group(['middleware' => 'loginTrue'], function () {
	Route::get('/','IndexController@index')->name('web.index');
	Route::get('/loginOut','IndexController@loginOut')->name('web.loginOut');
	Route::get('/loginHistory','IndexController@loginHistory')->name('web.loginHistory');
	Route::get('/login/history','IndexController@getLoginHistory')->name('web.login.history');
	Route::get('/password/update','IndexController@passwordUpdate')->name('web.password.update');

	Route::prefix('project')->group(function($route){
		$route->get('/create','ProjectController@projectCreate')->name('web.project.create');
		$route->get('/update','ProjectController@projectUpdate')->name('web.project.update');
		$route->get('/getData','ProjectController@getProjectData')->name('web.project.getData');
		$route->get('/list','ProjectController@projectList')->name('web.project.list');
		$route->get('/remove','ProjectController@projectRemove')->name('web.project.remove');
		$route->get('/search','ProjectController@search')->name('web.project.search');
		$route->get('/search/request','ProjectController@searchRequest')->name('web.project.search.request');
		$route->get('/apply','ProjectController@searchApply')->name('web.project.apply');
		$route->get('/apply/list','ProjectController@applyList')->name('web.project.applyList');
		$route->get('/apply/getlist','ProjectController@getApplyList')->name('web.project.apply.getlist');
		$route->get('/apply/update','ProjectController@applyUpdate')->name('web.project.apply.update');
		$route->get('/apply/out','ProjectController@applyOut')->name('web.project.apply.out');

		Route::prefix('api')->group(function($route){
			$route->get('/index/{id}','ApiController@index')->name('web.project.api.home');
			$route->get('/group/{id}','ApiController@group')->name('web.project.api.group');
			$route->get('/member/group','ApiController@getGroup')->name('web.project.api.groupList');
			$route->get('/create/group','ApiController@createGroup')->name('web.project.api.group.create');
			$route->get('/update/group','ApiController@updateGroup')->name('web.project.api.group.update');
			$route->get('/remove/group','ApiController@removeGroup')->name('web.project.api.group.remove');
			$route->post('/create','ApiController@createApi')->name('web.project.api.create');
			$route->get('/detail/{id}/{project}','ApiController@detailApi')->name('web.project.api.detail');
			$route->get('/delete','ApiController@deleteApi')->name('web.project.api.delete');
			$route->get('/edit/{id}/{project}','ApiController@editApi')->name('web.project.api.edit');
			$route->get('/getDetail','ApiController@getDetail')->name('web.project.api.getDetail');
			$route->post('/update','ApiController@updateApi')->name('web.project.api.update');
		});

		Route::prefix('model')->group(function($route){
			$route->get('/create','ApiController@createModel')->name('web.project.model.create');
			$route->get('/update','ApiController@updateModel')->name('web.project.model.update');
			$route->get('/detail','ApiController@getModelDetail')->name('web.project.model.detail');
			$route->get('/remove','ApiController@removeModel')->name('web.project.model.remove');
			$route->get('/list','ApiController@getMenu')->name('web.project.model.list');
		});
	});
});

