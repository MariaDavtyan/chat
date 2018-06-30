<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@WelcomePage');
//User login
Route::post('login','Auth\LoginController@UserLogin')->name('login');
//User logout
Route::get('logout', 'Auth\LoginController@logout');
//add group
Route::post('addgroup','GroupController@AddGroup')->name('addgroup');
//get chat info
Route::get('chat_info','MessageController@GetChatInfo');
//add message to db
Route::post('message','MessageController@AddMessageToDb');
Route::post('privatechat/message','MessageController@AddMessageToDb');
//private chat
Route::get('privatechat/{url}','GroupController@GetPrivateChat');
