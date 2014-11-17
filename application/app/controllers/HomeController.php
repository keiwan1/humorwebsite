<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	//make a list of the medias in other words the posts of users and return the view that contains this list. gives
	//a list of images/videos like 9gag homepage
	public function home()
	{
		$media = Media::where('active', '=', 1)->orderBy('created_at', 'desc')->get();
		$data = array(
					'media' => $media
					);

		return View::make('media.list_media', $data);
	}

}
