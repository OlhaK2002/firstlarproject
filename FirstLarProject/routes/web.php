<?php

Auth::routes();


Route::get('/', 'CommentController@comment')->name('comment');
Route::post('/reply', 'CommentController@reply')->name('reply');

