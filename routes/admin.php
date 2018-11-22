<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2018/11/21
 * Time: 15:02
 */

Route::group(['middleware' => 'CheckAdmin'], function () {
	Route::get('/','IndexController@index')->name('admin.index');
	Route::get('/project','ProjectController@index')->name('admin.project');
	Route::get('/project/list','ProjectController@projectList')->name('admin.project.list');
	Route::get('/member','UserController@index')->name('admin.member');
	Route::get('/member/list','UserController@userList')->name('admin.member.list');
	Route::get('/history','UserController@history')->name('admin.history');
	Route::get('/history/list','UserController@historyList')->name('admin.history.list');

});