<?php

abstract class MainAlgorithm {

	public static function make()
	{
		$args = func_get_args();

		$query = static::query();

		foreach ($args as $method)
		{
			if(method_exists(get_called_class(), $method))
			{
				$query = static::$method( $query );
			}
		}

		return $query;
	}

    public static function query()
    {        
    	$class = static::$class;
        
        return $class::query();
    }
}