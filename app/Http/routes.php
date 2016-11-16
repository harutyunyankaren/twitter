<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::group(['middleware' => 'auth'], function (){

    Route::post('create-post', 'PostController@createPost');
    Route::get('profile', 'PostController@showProfile');
    Route::post('folow', 'PostController@folow');
    Route::post('notfolow', 'PostController@notFolow');
    Route::get('friends', 'FriendController@showFriends');
    Route::post('friendRequest', 'FriendController@friendRequest');
    Route::post('cancelOrDeleteFriendRequest', 'FriendController@cancelOrDeleteFriendRequest');
    Route::post('acceptFriendRequest', 'FriendController@acceptFriendRequest');
    Route::post('searchUsers', 'FriendController@searchUsers');
    Route::get('messages', 'MassegeController@messages');
    Route::get('chat/{id}', 'MassegeController@showChat');
    Route::post('sendMessage', 'MassegeController@sendMessage');
    Route::post('readMessage', 'MassegeController@readMessage');
    Route::post('newMessage', 'MassegeController@newMessage');
    Route::post('updateMessage', 'MassegeController@updateMessage');
    Route::post('updateCountUserMessage', 'MassegeController@updateCountUserMessage');
    Route::post('updateNewMessage', 'MassegeController@updateNewMessage');


});


Route::get('/home', 'HomeController@index');
