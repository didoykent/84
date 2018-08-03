<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/', ['as' => 'home_path', 'uses' => function () {
    return view('welcome');
}]);


Route::post('mega_signin', 'Api\Auth\SignInController@megaSignIn');






Route::group(['middleware' => ['jwt.auth']], function(){

Route::post('uploadFile', 'Api\Auth\ChatController@uploadFile');
Route::post('uploadAvatar', 'Api\Auth\ChatController@uploadAvatar');
  Route::post('student_logout', 'Api\Auth\LogOutController@studentLogOut');
Route::post('student_signup', 'Api\Auth\SignUpController@studentSignUp');
  Route::get('getFriendLists', 'Api\Auth\ChatController@getFriendLists');
  Route::get('getUserId', 'Api\Auth\ChatController@getCurrentUserId');
  Route::get('getUnreadMessages', 'Api\Auth\ChatController@getUnreadMessages');
  Route::post('saveMessage', 'Api\Auth\ChatController@saveMessage');
  Route::put('editMessage/{id}', 'Api\Auth\ChatController@editMessage');
  Route::post('getMessages', 'Api\Auth\ChatController@getMessages');
  Route::post('initializeData', 'Api\Auth\ChatController@initializeData');


});
