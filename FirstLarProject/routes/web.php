<?php

Auth::routes();


Route::get('/', 'CommentController@commentView')->name('view');
Route::post('/comment', 'CommentController@comment')->name('comment');
Route::post('/reply', 'CommentController@reply')->name('reply');

