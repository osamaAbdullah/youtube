<?php

Route::group(['middleware' => ['auth']],function (){

    Route::GET('/upload', 'VideoUploadController@index');
    Route::POST('/upload', 'VideoUploadController@store');

    Route::GET('/videos','VideoController@index');
    Route::GET('/videos/{video}/edit','VideoController@edit');

    Route::POST('/videos/store', 'VideoController@store');
    Route::DELETE('/videos/{video}/delete', 'VideoController@delete');
    Route::PUT('/videos/{video}/update', 'VideoController@update');

    Route::GET('/channels/{channel}/edit', 'ChannelSettingsController@edit');
    Route::PUT('/channels/{channel}/update', 'ChannelSettingsController@update');


});

Route::GET('/videos/{video}/show', 'VideoController@show');

Route::get('images/{image}/view','VideoController@getImage');
Route::get('videos/{video}/view','VideoController@getVideo');

Route::GET('/channels/{channel}/show', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'PrimaryPagesController@index');

Auth::routes();






//Route::GET('/videos/{video}/show',[
//    'uses' => 'VideoController@show',
//    'as'   => 'video.show',
//]);
//Route::GET('/videos/{video}/show', 'VideoController@show')->name('video.show');