<?php

class UsersController extends \BaseController {

	/**
	 * Store a newly created resource in storage.
	 * Register a new user
	 *
	 * @return Response
	 */
	public function store()
	{
		# get input
		$data = Input::only(['username', 'email', 'password', 'password_confirmation']);

		# input validation
		$validator = Validator::make(
					$data,
					[
						'username' 					=> 'required|unique:users|min:4',
						'email'						=> 'required|unique:users|email|min:5',
						'password'					=> 'required|min:6|confirmed',
						'password_confirmation'		=> 'required|min:6'
					]
		);

		if($validator->fails()) {
			return Redirect::to('register')->withErrors($validator)->withInput();
		}
		else {
		    # save User record
			$hashedPassword = Hash::make(Input::get('password'));
			$user = new User;
			$user->username = Input::get('username');
			$user->email = Input::get('email');
			$user->password = $hashedPassword;
			$user->save();


            # create an user own directory and auto-login after sign up
            if (Auth::attempt(array(
							'email'		=> Input::get('email'),
							'password'	=> Input::get('password')
							), true)) {

                File::makeDirectory(public_path().'/userimage/'.Auth::user()->id, 0777, true, true);

                # save Email record
                $email = new Email;
                $email->user_id = Auth::user()->id;
                $email->email = Auth::user()->email;
                $email->md5 = md5( strtolower(trim(Input::get('email'))));

                $email->save();

                return Redirect::to('/user/home');
			}
			else return Redirect::to('/');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return View::make('user');
	}

	public function login()
	{

		$input = Input::only('email', 'password');

		$validator = Validator::make(
			$input,
			[
				'email' 						=> 'required|email|min:5',
				'password'						=> 'required|min:6'
			]
		);

		if($validator->fails()) {
			return Redirect::to('/')->withErrors($validator)->withInput();
		}

		elseif (Auth::attempt($input, true)) {
			return Redirect::to('/user/home');
		}

		else {
			$authError = 'The username and password you entered did not match our records. Please double-check and try again.';
			return Redirect::to('/')->withErrors($authError)->withInput();
		}
	}

	public function logout()
	{
		if (Auth::check()) Auth::logout();

		return Redirect::to('/');
	}

}
