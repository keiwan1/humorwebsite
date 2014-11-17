<?php

class Media extends Eloquent {

	protected $table = 'media';

	protected $guarded = array();
	
	public static $rules = array(
		'title' => 'required'
	);

	public function user(){
		return $this->belongsTo('User')->first();
	}

	public function comments(){
			return $this->hasMany('Comment')->where('parent_id', '=', 0);
	}
	
	public function totalComments(){
		return DB::table('comments')->where('media_id', '=', $this->id)->count();
	}


}