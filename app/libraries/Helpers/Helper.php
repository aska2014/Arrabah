<?php namespace Helpers;

class Helper {

	/** 
	 * Helper instnace.
	 *
	 * @var Helper
	 */
	protected static $instance;

	/**
	 * Singleton implementation
	 */
	private function __construct(){}

	/**
	 * Singleton instance.
	 *
	 * @return Helper
	 */
	public static function instance()
	{
		if(! static::$instance)

			static::$instance = new Helper;

		return $instance;
	}

	/**
	 * Get keys from the given inputs array
	 *
	 * @param  array $inputs
	 * @param  array $keys
	 * @return array
	 */
	public function arrayGetKeys( $inputs, $keys )
	{
		$newInputs = array();
		foreach ($inputs as $key => $value) {

			if(in_array($key, $keys))

				$newInputs[ $key ] = $value;
		}

		return $newInputs;
	}

	/**
	 * Replace all replacers from string
	 * 
	 * @param  string $string
	 * @param  array  $replacers
	 * @return string
	 */
	public function replaceAll( $string, $replacers )
	{
		foreach ($replaces as $key => $value)
		{
			$string = str_replace('{' . $key . '}', $value, $string);
		}

		return $string;
	}
}