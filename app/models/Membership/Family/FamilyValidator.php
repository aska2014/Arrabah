<?php namespace Membership\Family;

use ValidatorInterface, Validator;

class FamilyValidator implements ValidatorInterface {

	/**
	 * Filter inputs.
	 *
	 * @return array
	 */
	public static function filter( array $inputs )
	{
		return static::stripTags(\array_get_keys($inputs, 'name'));
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
		Validator::make($inputs, array(

			'name' => 'required|unique:families'

		), array(

			'name.required' => 'بجب إدخال اسم العائلة.',
			'name.unique'   => 'اسم العائلة موجود من قبل.'
		));
	}

}