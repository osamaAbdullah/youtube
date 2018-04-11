<?php

Route::group(['middleware' => ['auth']],function (){

    Route::GET('/video/upload',   'VideoUploadController@index');
    Route::POST('/video/store', 'VideoController@store');
    Route::POST('/video/upload', 'VideoUploadController@store');
    Route::GET('/videos/{video}', 'VideoController@show');
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

    Route::GET('/channels/{channel}/subscriptions', 'ChannelSubscriptionController@get');
    Route::POST('/channels/{channel}/subscriptions/store', 'ChannelSubscriptionController@store');
    Route::DELETE('/channels/{channel}/subscriptions/delete', 'ChannelSubscriptionController@delete');

});
// the two other routes of votes are depending on this if you wanna
//change this you may send custom routes a props to the vue component
Route::GET('/videos/{video}/votes', 'VideoVoteController@show');

Route::GET('/videos/{video}/comments', 'VideoCommentController@index');

Route::GET('/videos/{video}/show', 'VideoController@show');

Route::POST('/videos/{video}/view', 'VideoViewController@store');

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