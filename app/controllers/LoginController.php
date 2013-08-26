<?php

class LoginController extends BaseController {

	protected $errors = '';


	public function __construct()
	{
		Asset::addPage('register');
	}

	public function getIndex()
	{
		return View::make('login.index');
	}


	public function postIndex()
	{
		// Get user inputs.
		$userInputs = Input::get('Login');

		$attemption = array('email' => $userInputs['email'], 'password' => $userInputs['password']);

		if(! $this->attempt( $attemption )) {

			$attemption = array('username' => $userInputs['email'], 'password' => $userInputs['password']);
			
			if(! $this->attempt( $attemption )) {

				$this->errors = 'بيانات الدخول غير صحيحة.';
			}
		}
		if($this->errors)

			return Redirect::action('LoginController@getIndex')->with('errors', $this->errors);

		return Redirect::to(Tracker::before('login'))->with('success', 'لقد قمت بالدخول بنجاح');
	}


	private function attempt( $attemption )
	{
		// Validate user credentials without acctually login him in
		if(! Auth::validate($attemption))

			return false;

		$attemption['accepted'] = true;

		// Now attempt to login with username, password and acceptance
		if(! Auth::attempt($attemption, true, true))

			$this->errors = 'لم يتم قبولك بعد من قبل إدارة الموقع.';

		return true;
	}

}