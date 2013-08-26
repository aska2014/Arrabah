<?php

use Illuminate\Support\Facades\View as LaravelView;

class View extends LaravelView {

	public static function make( $file, $data = array() )
	{
		$view = parent::make( $file, $data );

		Tracker::save();

		$view->errors  = (array)Session::get('errors', array());
		$view->success = (array)Session::get('success', array());

		Session::forget('errors');
		Session::forget('success');

		return $view;
	}

}