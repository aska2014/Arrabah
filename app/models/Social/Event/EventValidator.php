<?php namespace Social\Event;

use ValidatorInterface;
use Validator;

class EventValidator implements ValidatorInterface {

	/**
	 * Filter inputs.
	 *
	 * @return array
	 */
	public static function filter( array $inputs )
	{
		return static::stripTags(\array_get_keys($inputs, array('title', 'description', 'date_of_event')));
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

			'title' => 'required',
			'description' => 'required'

		), array(

			'title.required' => 'يجب إختيار عنوان المناسبة.',
			'description.required' => 'يجب إدخال تفاصيل المناسبة.',

		));
	}

}