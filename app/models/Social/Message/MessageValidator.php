<?php namespace Social\Message;

use ValidatorInterface;
use Validator;

class MessageValidator implements ValidatorInterface {

	/**
	 * Filter inputs.
	 *
	 * @return array
	 */
	public static function filter( array $inputs )
	{
		return static::stripTags(\array_get_keys($inputs, array('title', 'description')));
	}

	private static function stripTags( $inputs )
	{
		array_walk($inputs, function( &$input )
		{
			$input = strip_tags($input);
		});

		return $inputs;
	}

	/**
	 * Validate inputs.
	 *
	 * @return Validator
	 */
	public static function validate( array $inputs )
	{
		return Validator::make($inputs, array(

			'description' => 'required'

		),array(

			'description.required' => 'يجب إدخال نص الرسالة.'

		));
	}


}