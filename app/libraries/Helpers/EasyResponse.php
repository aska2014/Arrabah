<?php namespace Helpers;

use Response, Redirect, Request;

class EasyResponse {

	/**
	 * Redirect to with message and body.
	 *
	 * @return Response|Redirect
	 */
	public static function to( $uri, $message, $body )
	{
		if(static::ajax()) return Response::json(array('message' => $message, 'body' => $body));
		else               return Redirect::to( $uri )->with($message, $body);
	}

	/**
	 * Redirect back or return json response with the given message and body.
	 *
	 * @param  string $message
	 * @param  string $body
	 * @return Response|Redirect
	 */
	public static function back( $message, $body )
	{
		if(static::ajax()) return Response::json(array('message' => $message, 'body' => $body));
		else               return Redirect::back()->with($message, $body);
	}

	/**
	 * Check if it's an ajax request.
	 *
	 * @return boolean
	 */
	public static function ajax()
	{
		return Request::ajax() || Input::get('ajax', false);
	}
}