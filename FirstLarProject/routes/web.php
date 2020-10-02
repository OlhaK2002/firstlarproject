<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'CommentController@comment')->name('comment');
Route::post('/reply', 'CommentController@reply')->name('reply');
//Route::get('/rep', 'ReplyController@reply');

