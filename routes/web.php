<?php

Route::group(['middleware' => ['auth']],function (){

    Route::GET('/video/upload',   'VideoUploadController@index');
    Route::POST('/video/store', 'VideoController@store');
    Route::POST('/video/upload', 'VideoUploadController@store');
    Route::PUT('/videos/{video}/update', 'VideoController@update');
    Route::GET('/videos','VideoController@index');
    Route::GET('/videos/{video}/edit','VideoController@edit');
    Route::DELETE('/videos/{video}/delete', 'VideoController@delete');

    Route::GET('/channels/{channel}/edit', 'ChannelSettingsController@edit');
    Route::PUT('/channels/{channel}/update', 'ChannelSettingsController@update');

    Route::POST('/videos/{video}/vote/store', 'VideoVoteController@store');
    Route::DELETE('/videos/{video}/vote/delete', 'VideoVoteController@delete');

    Route::POST('/videos/{video}/comment/store','VideoCommentController@store');
    Route::DELETE('/videos/{video}/comments/{comment}/delete', 'VideoCommentController@delete');


    Route::POST('/channels/{channel}/subscriptions/store', 'ChannelSubscriptionController@store');
    Route::DELETE('/channels/{channel}/subscriptions/delete', 'ChannelSubscriptionController@delete');

});
Route::GET('/channels/{channel}/subscriptions', 'ChannelSubscriptionController@get');

Route::GET('/videos/{video}/votes', 'VideoVoteController@get');

Route::GET('/videos/{video}/comments', 'VideoCommentController@index');

Route::GET('/videos/{video}/show', 'VideoController@show');

Route::POST('/videos/{video}/view/store', 'VideoViewController@store');

Route::get('images/{image}/view','VideoController@getImage');
Route::get('videos/{video}/view','VideoController@getVideo');

Route::GET('/channels/{channel}/show', 'ChannelController@show');

Route::get('/search', 'SearchController@index');




Route::get('/home', 'HomeController@index');

Route::get('/', 'PrimaryPagesController@index');

Auth::routes();






//Route::GET('/videos/{video}/show',[
//    'uses' => 'VideoController@show',
//    'as'   => 'video.show',
//]);
//Route::GET('/videos/{video}/show', 'VideoController@show')->name('video.show');