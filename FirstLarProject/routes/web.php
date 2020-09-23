<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'CommentController@commentAction')->name('comment');
Route::post('/reply', 'ReplyController@replyAction')->name('reply');
Route::get('/authorization/view', 'AuthorizationController@viewAction')->name('authorizationview');
Route::post('/authorization', 'AuthorizationController@loginAction')->name('authorization');
Route::get('/registration/view', 'RegistrationController@viewAction')->name('registrationview');
Route::post('/registration/register', 'RegistrationController@registerAction')->name('registration');

//Route::get('/authorization/ajax', 'AuthorizationController@ajaxAction')->name('authorization_ajax');
