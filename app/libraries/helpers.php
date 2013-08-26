<?php

if(! function_exists('array_check_keys')) {

	function array_get_keys( $inputs, $keys )
	{
		$newInputs = array();
		foreach ($inputs as $key => $value) {

			if(in_array($key, $keys))

				$newInputs[ $key ] = $value;
		}

		return $newInputs;
	}
}


if(! function_exists('replace_all')) {

	function replace_all( $string, $replaces )
	{
		foreach ($replaces as $key => $value)
		{
			$string = str_replace('{' . $key . '}', $value, $string);
		}

		return $string;
	}
}