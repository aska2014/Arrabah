<?php

class Messenger {

	protected $title;
	protected $description;
	protected $redirect;
	protected $redirectSeconds;
	protected $redirectUrl;

	/**
	 * Messenger constructor
	 *
	 * @param  string $title
	 * @param  string $description
	 * @param  bool   $redirect
	 * @param  int    $redirectSeconds
	 * @param  string $redirectUrl
	 * @return void
	 */
	public function __construct( $title, $description, $redirect = false, $redirectSeconds = 0, $redirectUrl = false )
	{
		$this->title           = $title;
		$this->description     = $description;
		$this->redirect        = $redirect;
		$this->redirectSeconds = $redirectSeconds;
		$this->redirectUrl     = $redirectUrl;
	}


	public function getTitle()
	{
		return $this->title;
	}
	
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Save Current state to the next request.
	 *
	 * @return void
	 */
	public function flash()
	{
		Session::flash('title'          , $this->title);
		Session::flash('description'    , $this->description);
		Session::flash('redirect'       , $this->redirect);
		Session::flash('redirectSeconds', $this->redirectSeconds);
		Session::flash('redirectUrl'    , $this->redirectUrl);
	}

	/**
	 * Get flashed variables
	 *
	 * @return Messenger|null
	 */
	public static function get()
	{
		if(Session::get('title', false) && Session::get('description', false))
			
			return new Messenger(
				Session::get('title'), 
				Session::get('description'), 
				Session::get('redirect'), 
				Session::get('redirectSeconds'), 
				Session::get('redirectUrl')
			);

		return null;
	}
}