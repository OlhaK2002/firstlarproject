<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'CommentController@comment')->name('comment');
Route::post('/reply', 'ReplyController@reply')->name('reply');
