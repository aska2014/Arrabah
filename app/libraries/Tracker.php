<?php

class Tracker {

	const SESSION_KEY = 'efdsk312Q';
	const MAX_SAVE    = 5;

	protected static $save = false;

	protected static $orderMade = false;

	public static function dontSave()
	{
		if( static::$orderMade) return;

		static::$orderMade = true;

		static::$save = false;
	}

	public static function save()
	{
		if( static::$orderMade) return;

		static::$orderMade = true;
		
		static::$save = true;
	}

	public static function done()
	{
		if(! static::$save) return;

		static::add(Route::currentRouteName(), Request::path());
	}

	public static function getPrevious()
	{
		$all = static::get();

		return $all[ count($all) - 1 ];
	}

	public static function add( $route, $value )
	{
		$all = static::get();

		$all[$route] = $value;

		if(count($all) > static::MAX_SAVE) array_shift($all);

		Session::put(static::SESSION_KEY, $all);
	}

	public static function get()
	{	
		return Session::get(static::SESSION_KEY);
	}


	public static function before( $beforeRoute )
	{
		if(! static::get()) return '';
		
		$all = array_reverse(static::get());

		foreach ($all as $route => $path)
		{
			if($route != $beforeRoute) 

				return $path;
		}
	}
}