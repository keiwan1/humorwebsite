<?php

class Comment extends Eloquent {

	protected $table = 'comments';

	protected $guarded = array();
	
	public static $rules = array(
		'comment' => 'required'
	);

	public function user(){
		return $this->belongsTo('User')->first();
	}

	public function media(){
		return $this->belongsTo('Media')->first();
	}

	public function children(){
		 return Comment::where('parent_id', '=', $this->id)->get();
	}

	public function upVotes(){
		return DB::table('comment_votes')->where('comment_id', '=', $this->id)->sum('up');
	}

	public function downVotes(){
		return DB::table('comment_votes')->where('comment_id', '=', $this->id)->sum('down');
	}

	public function totalVotes(){
		$upVotes = DB::table('comment_votes')->where('comment_id', '=', $this->id)->sum('up');
		$downVotes = DB::table('comment_votes')->where('comment_id', '=', $this->id)->sum('down');
		$totalVotes = $upVotes - $downVotes;
		return $totalVotes;
	}

	public function totalFlags(){
		return DB::table('comment_flags')->where('comment_id', '=', $this->id)->count();
	}
	



}