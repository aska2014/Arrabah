<?php namespace Social\Job;

use ValidatorInterface;
use Validator;

class JobValidator implements ValidatorInterface {

	/**
	 * Filter inputs.
	 *
	 * @return array
	 */
	public static function filter( array $inputs )
	{
		return static::stripTags(\array_get_keys($inputs, array('title', 'description', 'professions', 'place')));
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
            'description' => 'required',
            'professions' => 'required',
            'place' => 'required',

		), array(

			'title.required' => 'يجب إدخال عنوان الوظيفة.',
            'description.required' => 'يجب إدخال تفاصيل الوظيفة.',
            'professions.required' => 'يجب إدخال الخبرات المطلوبة.',
            'place.required' => 'يجب إدخال مكان الوظيفة',

		));
	}

}