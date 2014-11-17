<?php

class CommentsController extends BaseController {

	protected $comment;
	
	public function __construct(Comment $comment){
	
		$this->comment = $comment;
	}
	
		//posting a comment, validation so that no empty fields. and add it.
		public function store()
		{
			$input = Input::all();
			$media = Media::where('id', '=', $input['media_id'])->first();
			
			$validation = Validator::make($input, Comment::$rules);

			if($validation->passes()){

				$input['comment'] = htmlspecialchars($input['comment']);
				$input['user_id'] = Auth::user()->id;
				
				if($media->user()->id == $input['user_id']){
					$input['seen'] = '1';
				}
				$this->comment->create($input);
			}
			
			return Redirect::to("/media/$media->slug")->withErrors($validation);

		}
	
		
		public function destroy()
		{

		}





}