<?php

interface ValidatorInterface {

	/**
	 * Filter inputs.
	 *
	 * @return array
	 */
	public static function filter( array $inputs );

	/**
	 * Validate inputs.
	 *
	 * @return Validator
	 */
	public static function validate( array $inputs );
	
}