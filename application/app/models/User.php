<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	public function comments(){
		return $this->hasMany('Comment');
	}

	public function unseenComments(){

		$mediass = Media::where('user_id', '=', $this->id)->lists('id');

		if(isset($mediass) && !empty($mediass)){
			return $comments = Comment::whereIn('media_id', $mediass)->where('seen', '=', '0')->get();
    	}

    	return false;
    
	}

	


}
