<?php

use Illuminate\Support\Facades\Auth as LaravelAuth;

class Auth extends LaravelAuth{ 


	public static function accepted()
	{
		$user = static::user();

		return $user && $user->accepted ? $user : null;
	}

	/**
	 * Hash the given value with the hashing algorithm the authentication
	 * class use which is Hash::make
	 *
	 * @param  string $value
	 * @return string
	 */
	public static function hash( $value )
	{
		return Hash::make( $value );
	}

}