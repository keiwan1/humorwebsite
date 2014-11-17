<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@home');


Route::post('noticomment', function()
{
	$data = Input::all();
	if(Request::ajax()){
		DB::table('comments')->where('id', $data['id'])->update(array('seen' => 1));
}
});

// ********** USER AUTHENTICATION ROUTES  ********** //

// SIGN IN

Route::get('signin', array('as' => 'signin', function (){
	return View::make('authent.signin');
}))->before('guest');

Route::post('signin', 'UserController@signin');

// SIGNUP

Route::get('signup', array('as' => 'signup', function ()
{
	return View::make('authent.signup');
}))->before('guest');

Route::post('signup', 'UserController@signup');

Route::get('logout', array('as' => 'logout', function()
{
	Auth::logout();
	return Redirect::to('/');
}));

// ********** MEDIA ROUTES ********** //

Route::get('media/{slug}', 'MediaController@show');

// **********	USER PROFILE ROUTES   ********** //

Route::get('u/{username}', 'UserController@profile');
Route::get('u/{username}/likes', 'UserController@profile_likes');

// **********	COMMENTS ROUTES  **********//

Route::resource('comments', 'CommentsController', array('only' => array('store', 'destroy')));

Route::post('comments/vote_up', 'CommentsController@vote_up');
Route::post('comments/vote_down', 'CommentsController@vote_down');
Route::post('comments/add_flag', 'CommentsController@add_flag');


//this group of routes goes through filter auth.
Route::group(array('before' => 'auth'), function()
{
	/********** Upload Routes **********/
	Route::get('upload', array('as' => 'upload', function (){
		return View::make('media.upload');
	}));

	Route::resource('media', 'MediaController', array('except' => array('create')));
	//Route::get('upload', 'MediaController@create');
	//Route::post('upload', 'MediaController@create');
	//Route::post('image_ajax_upload', 'MediaController@image_ajax_upload');
	

	/********** DELETE Media/Comments Routes *********/
	//Route::get('media/delete/{id}', 'MediaController@delete');
	Route::get('comments/delete/{id}', 'CommentsController@delete');

	/********** User Routes **********/
	//Route::get('user/{username}/edit', 'UserController@edit');
	//Route::get('user/{username}/points', 'UserController@points');
	//Route::get('user/{username}/asked', 'UserController@asked');
	//Route::post('user/update/{id}', 'UserController@update');

});