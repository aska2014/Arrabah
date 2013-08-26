<?php

class BrainyResponse {

	public static function backWithErrors( $errors )
	{
		if(static::ajax()) return Response::json(array('message' => 'error', 'body' => $errors));
		else               return Redirect::back()->with('errors', $errors);
	}

	public static function backWithSuccess( $success )
	{
		if(static::ajax()) return Response::json(array('message' => 'success', 'body' => $success));
		else               return Redirect::back()->with('success', $success);
	}


	public static function ajax()
	{
		return Request::ajax() || Input::get('ajax', false);
	}
}