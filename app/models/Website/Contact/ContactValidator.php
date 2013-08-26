<?php namespace Website\Contact;

use ValidatorInterface;
use Validator;

class ContactValidator implements ValidatorInterface {

	/**
	 * Filter inputs.
	 *
	 * @return array
	 */
	public static function filter( array $inputs )
	{
		return static::stripTags(\array_get_keys($inputs, array('title', 'description', 'type')));
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
		$types = array(Contact::QUESTION, Contact::SUGGESTION);

		return Validator::make($inputs, array(

			'title' => 'required',
			'description' => 'required',
			'type' => 'required|in:' . implode(',', $types),
		
		), array(

			'title.required' => 'يجب إدخال عنوان الرسالة',
			'description.required' => 'يجب إدخال نص الرسالة',
			'type.required' => 'يجب إختيار نوع الرسالة',
			'type.in' => 'يجب إختيار نوع الرسالة',

		));
	}

} 