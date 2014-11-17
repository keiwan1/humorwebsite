<?php

class MediaController extends BaseController {

	protected $media;
	
	public function __construct(Media $media){
	
		$this->media = $media;
	}
	
		//route to /media
		public function index()
		{
			return Redirect::to('/');
		}
	
		/**
		 * upload a new media.
		 */
		public function store()
		{
			//grab all inputs from the upload fields of the form in the view
			$input = Input::all();

			//make sure the user is the same as the logged in one
			$input['user_id'] = Auth::user()->id;
			
			//make sure title is required see model of Media for rules.
			$validation = Validator::make($input, Media::$rules);

			//nukta means text. you can post a text, video by url (youtube), image through file upload or by url.
			$valid_media = false;
			if(isset($input['nukta']) && !empty($input['nukta'])){
				$valid_media = true;
			} else if(isset($input['pic_url']) && $input['pic_url'] != ''){
				$valid_media = true;
			} else if(isset($input['vid_url']) && $input['vid_url'] != ''){
				$valid_media = true;
			} else if(isset($input['file']) && !empty($input['file'])){
				$valid_media = true;
			}

			//check what the user wants to upload. and use the helper file to upload it. or return to page with errors.
			//errors you can see lang folder. 
			if ($validation->passes() && $valid_media)
			{

				if($input['radiooption'] == 'pic'){
					if(isset($input['pic_url']) && $input['pic_url'] != ''){
						$input['pic_url'] = Helper::uploadImage($input['pic_url'], 'images', $input['title'], 'url');
					} else if(isset($input['file'])){
						$input['pic_url'] = Helper::uploadImage(Input::file('file'), 'images');
						if($input['pic_url'] == '0'){
							return Redirect::to('/upload')->with(array('Errornote' => Lang::get('posts.image_error')));
						}

					}
						$input['pic'] = 1;
						$input['category_id'] = 1;
						unset($input['vid_url']);
						unset($input['nukta_text']);
						unset($input['file']);
					

				} elseif($input['radiooption'] == 'vid'){
					if(isset($input['vid_url']) && $input['vid_url'] != ''){
						if (!(strpos($input['vid_url'], 'youtube') > 0 || strpos($input['vid_url'], 'youtu.be') > 0)) {
							return Redirect::to('/upload')->with(array('Errornote' => Lang::get('posts.video_error')));
						}
						unset($input['file']);
						unset($input['pic_url']);
						$input['category_id'] = 2;
						$input['vid'] = 1;
					}
				}else{
					if(isset($input['nukta']) && strlen($input['nukta']) > 30){
						unset($input['file']);
						unset($input['vid_url']);
						unset($input['pic_url']);
						$input['nukta_text'] = $input['nukta'];
						$input['nukta'] = 1;
						$input['category_id'] = 3;
					} else{
						return Redirect::to('/upload')->with(array('Errornote' => Lang::get('posts.nukta_error')));
					}

				}


//this is for allowing users to post vimeo urls or vines but this is not used right now.
				//unset($input['img_url']);

				/*if(isset($input['vid'])){
					if(isset($input['vid_url'])){
						unset($input['vid']);
						
						if (strpos($input['vid_url'], 'youtube') > 0 || strpos($input['vid_url'], 'youtu.be') > 0) {
							$video_id = Youtubehelper::extractUTubeVidId($input['vid_url']);
							if(isset($video_id[1])){
								$img_url = 'http://img.youtube.com/vi/'. $video_id . '/0.jpg';
								$input['pic_url'] = Helper::uploadImage($img_url, 'images', true, Helper::slugify($input['title']), 'url');
							} else {
								unset($input['vid_url']);
							}
							$input['vid'] = 1;
						} elseif(strpos($input['vid_url'], 'vimeo') > 0) {
							$vimeo_id = (int)substr(parse_url($input['vid_url'], PHP_URL_PATH), 1);
							$link = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vimeo_id.php"));
							$image = $link[0]['thumbnail_large'];  
							
							$input['pic_url'] = Helper::uploadImage($image, 'images', Helper::slugify($input['title']), 'url');
							$input['vid'] = 1;
						} elseif(strpos($input['vid_url'], 'vine') > 0){
							$video_id = explode('/v/', $input['vid_url']);
							$video_id = str_replace('/embed', '', $video_id[1]);
							$video_id = str_replace('/', '', $video_id);
							if(isset($video_id)){
								ini_set('default_socket_timeout', 120);
								$vine = file_get_contents("http://vine.co/v/$video_id");
								preg_match('/property="og:image" content="(.*?)"/', $vine, $matches);

								$image = ($matches[1]) ? $matches[1] : '';
								$input['pic_url'] = Helper::uploadImage($image, 'images', Helper::slugify($input['title']), 'url');
							} else {
								unset($input['vid_url']);
							}
							$input['vid'] = 1;
						}
					}
				}
					
				//$this->add_daily_media_points();*/

				//if in the settings table auto approve is off, then it assigns active=0 to the uploaded posts
				//this so that the adminstrator can manually approve posts.
				$setting = Setting::first();
				if(!$setting->auto_approve_posts){
					$input['active'] = 0;
				}

				/*if(isset($input['nsfw'])){
					$input['nsfw'] = 1;
				} else {
					$input['nsfw'] = 0;
				}*/

				$input['title'] = htmlspecialchars(stripslashes($input['title']));

				//this makes a random slug for in the url. example: localhost/media/UHFEDR
				$input['slug'] = $this->slugIdforMedia();

				/*if(isset($input['description'])){
					$input['description'] = htmlspecialchars(stripslashes($input['description']));
				}*/
					
				$slugexist = Media::where('slug', '=', $input['slug'])->first();
				
				while(isset($slugexist->id)){
					$input['slug'] = $this->slugIdforMedia();
					$slugexist = Media::where('slug', '=', $input['slug'])->first();	
				}

				unset($input['radiooption']);
				

				$new_media = $this->media->create($input);

				
				return Redirect::to('media' . '/' . $new_media->slug);
			}

			
		return Redirect::to('/upload')->withErrors($validation)->with(array('Errornote' => Lang::get('posts.error_uploading')));
		
	
		}
	
	
	//this will show the edit form of the media to be updated
		public function edit($id)
		{
		}
	//this will update a media resource
		public function update($id)
		{
		}
	//this deletes a media resource
		public function delete($id)
		{
		}
	
	
	
	


		
	//displays a single media with slug, like /media/slug.
	public function show($slug) {
		
		$media = $this->media->where('slug', '=', $slug)->first();
		$commentlist = $media->comments;

		if(isset($media)){

			$view_increment = $this->increaseViewCount($media->id);
			
			//unnecessary code not used.
			/*$next = Media::where('active', '=', 1)->where('created_at', '>', date("Y-m-d H:i:s", strtotime($media->created_at)) )->first();
			$previous = Media::where('active', '=', 1)->where('created_at', '<', date("Y-m-d H:i:s", strtotime($media->created_at)) )->orderBy('created_at', 'desc')->first();
			$media_next = Media::where('active', '=', 1)->where('created_at', '>=', date("Y-m-d H:i:s", strtotime($media->created_at)) )->take(6)->get();
	
			$next_media_count = $media_next->count();
	
			if($next_media_count < 6){
				$get_prev_results = 6 - $next_media_count;
				$media_prev = Media::where('active', '=', 1)->where('created_at', '<', date("Y-m-d H:i:s", strtotime($media->created_at)) )->orderBy('created_at', 'DESC')->take($get_prev_results)->get();
			} else{
				$media_prev = array();
			}*/
	
			$data = array(
				'media' => $media,
				'commentlist' => $commentlist
				/*'media_next' => $media_next,
				'next' => $next,
				'previous' => $previous,
				'media_prev' => $media_prev,
				'view' => 'single',
				'view_increment' => $view_increment,*/
				);

			return View::make('media.show', $data);
		} else {
			return Redirect::to('/');
		}


	}

	//increase the view of a post. checks if the media id is in the Session if not increase view and then add it to Session
	public function increaseViewCount($id){

		$empty_array = array();
		if (! array_key_exists($id, Session::get('viewed_media', $empty_array) ) ) {
            
            try{
	            // increment view
				$media = Media::find($id);
				$media->views = $media->views + 1;
				$media->save();

	            // Add key to the view_media session
	        	Session::put('viewed_media.'.$id, time());
	        	return true;

	        } catch (Exception $e){
	        	return false;
	        }
        } else {
        	return false;
        }
	
	
	
	}

	public function slugIdforMedia(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < 7; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
	}


	

	
}