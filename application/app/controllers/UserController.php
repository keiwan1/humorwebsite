<?php

class UserController extends BaseController {

	public $restful = true;

	public static $rules = array(
		'name' => 'required|min:3',
        'email' => 'required|email',
        'password' => 'required|min:4'
    );

    // *********** CREATE A NEW USERNAME WITH USERNAME EMAIL AND PASSWORD ********** //

	private function new_user($username, $email, $password){
	    $user = new User;
	    $number = rand(0, 5);
	    $user->username = $username;
	    $user->email = $email;
	    $user->password = $password;
	    $user->avatar = 'defp_'. $number . '.jpg';
	    $user->comavatar = 'compic_'. $number .'.jpg'; 
	    $user->save();

	    return $user;
	}

    // *********** USER SIGNUP ********** //

	public function signup(){

		$validation = Validator::make( Input::all(), static::$rules );

		if($validation->fails()){

			return Redirect::route('signup')->withErrors($validation);
			//with(array('note' => Lang::get('auth.signup_error')));

		} else{

		$username = htmlspecialchars(stripslashes(Input::get('name')));

		$user = User::where('username', '=', $username)->first();

		if(!$user){

			if( count(explode(' ', $username)) == 1 ){
				if(Input::get('password') != ''){
					
					$user = $this->new_user( $username, Input::get('email'), Hash::make(Input::get('password')) ); 
			    
				    if($user){
				    	Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')));
				    }
				    
				    return Redirect::to('/')->with(array('note' => Lang::get('auth.signup_success')));
				} 
			}else {
					return Redirect::route('signup')->with(array('usernote' => Lang::get('auth.username_no_spaces')));
				}
		
		} else {
				return Redirect::route('signup')->with(array('usernote' => Lang::get('auth.username_in_use')));
			}

	}
}


//the user can sign in by email or by his/her username
	public function signin(){
	
			$username_login = array(
	            'username' => Input::get('name'),
	            'password' => Input::get('password')
	        );

	        $email_login = array(
	        	'email' => Input::get('name'),
	        	'password' => Input::get('password')
	        );
	        
	        //attempts the login with the input and reacts accordingly
	        if (Auth::attempt($username_login) || Auth::attempt($email_login)) {

				if(Auth::user()->active){ 		
				    return Redirect::to('/')->with('note', Lang::get('auth.signin_success'));
				 } else {
				    Auth::logout();
				    return Redirect::route('signin')->with(array('Signinnote' => 'This account is no longer active'));
				 }

			} else {
			        // auth failure! redirect to login with errors
			        return Redirect::route('signin')->with(array('Signinnote' => Lang::get('auth.signin_error')))->withInput();
			    }
		




	
		}



		//grabs user and its posts for the profile, returns the view with these details
		public function profile($username){
			$user = User::where('username', '=', $username)->first();
			$posts = Media::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();
			$data = array(
			'user' => $user,
			'posts' => $posts
			);
			return View::make('user.index', $data);
		}

		public function profile_likes($username){}

	

}

