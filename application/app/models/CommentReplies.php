<?php

class CommentReplies extends Eloquent {

	protected $table = 'comment_replies';
	protected $guarded = array();
	public static $rules = array();

	public function comment(){
		return $this->belongsTo('Comment')->first();
	}

	public function user(){
		return $this->belongsTo('User')->first();
	}

	public function media(){
		return $this->belongsTo('Media')->first();
	}

}