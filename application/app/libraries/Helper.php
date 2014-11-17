<?php

class Helper {

	//this method is used to upload an image either through a link or by file.
	public static function uploadImage($image, $folder, $filename = '', $type = 'upload'){


		if($folder == 'images'){
			$month_year = date('FY').'/';
		} else {
			$month_year = '';
		}

		$upload_folder = 'content/uploads/' . $folder . '/'.$month_year;

		if ( @getimagesize($image) ){
			$originalwidth = getimagesize($image)[0];

			// if the folder doesn't exist then create it.
			if (!file_exists($upload_folder)) {
				mkdir($upload_folder, 0777, true);
			}

			if($type =='upload'){

				$filename =  $image->getClientOriginalName();

				// if the file already exists give it another unique name
				while (file_exists($upload_folder.$filename)) {
					$filename =  uniqid() . '-' . $filename;
				}


				$uploadSuccess = $image->move($upload_folder, $filename);

				//if the img is a gif then add extension to name. later used to make the gif images move by click
				if(strpos($filename, '.gif') > 0){
					$new_filename = str_replace('.gif', '-animation.gif', $filename);
					copy($upload_folder . $filename, $upload_folder . $new_filename);
				}

			} else if($type = 'url'){
				
				$file = file_get_contents($image);

				if(strpos($image, '.gif') > 0){
					$extension = '-animation.gif';
				} else {
					$extension = '.jpg';
				}

				$filename = $filename . $extension;

				if (file_exists($upload_folder.$filename)) {
					$filename =  uniqid() . '-' . $filename . $extension;
				}

			    if(strpos($image, '.gif') > 0){
					file_put_contents($upload_folder.$filename, $file);
					$filename = str_replace('-animation.gif', '.gif', $filename);
				}

			    file_put_contents($upload_folder.$filename, $file);

			}
		   
			//for later use, to disable watermark or enable
			$settings = Setting::first();

			$img = Image::make($upload_folder . $filename);

			if($folder == 'images'){

				if($originalwidth > 600){
				$img->resize(600, null)->insert(public_path('assets/img/watermark.png'), 'bottom-right')->save($upload_folder . $filename);
				}else{
				$img->insert(public_path('assets/img/watermark.png'), 'bottom-right')->save($upload_folder . $filename);
				}
			} else if($folder == 'avatars'){
				$img->resize(140, 140)->save($upload_folder . $filename);
			}

				return $month_year . '/' . $filename;

		} else {
			return false;
		}
	}

	//getting youtube id from a url
	public static function getYoutubeid($videoUrl){
		/*
		* type1: http://www.youtube.com/watch?v=H1ImndT0fC8
		* type2: http://www.youtube.com/watch?v=4nrxbHyJp9k&feature=related
		* type3: http://youtu.be/H1ImndT0fC8
		*/

		$vid_id = "";
		$flag = false;
		if(isset($videoUrl) && !empty($videoUrl)){
			/*case1 and 2*/
			$parts = explode("?", $videoUrl);
			if(isset($parts) && !empty($parts) && is_array($parts) && count($parts)>1){
				$params = explode("&", $parts[1]);
				if(isset($params) && !empty($params) && is_array($params)){
					foreach($params as $param){
						$kv = explode("=", $param);
						if(isset($kv) && !empty($kv) && is_array($kv) && count($kv)>1){
							if($kv[0]=='v'){
								$vid_id = $kv[1];
								$flag = true;
								break;
							}
						}
					}
				}
			}
			
			/*case 3*/
			if(!$flag){
				$needle = "youtu.be/";
				$pos = null;
				$pos = strpos($videoUrl, $needle);
				if ($pos !== false) {
					$start = $pos + strlen($needle);
					$vid_id = substr($videoUrl, $start, 11);
					$flag = true;
				}
			}
		}
		return $vid_id;
	}

//when clicked on a notification that you have a new comment on your post, it changes it to the database to seen.
	public static function notifiedclick($comment){

		DB::table('comments')->where('id','=', $comment->id)->update(array('seen' => 1));
		return URL::to('media') . '/' .$comment->media()->slug;
	}
}