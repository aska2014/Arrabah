<?php

use Illuminate\Support\Facades\Route as laravelRoute;

class Route extends laravelRoute {

	public static function myController( $controllers )
	{
		$types = array('get', 'post');
		$wheres = array('{id}' => '[0-9]+', '{title}' => '.*');

		foreach ($controllers as $route => $controller)
		{
			$uri = $controller[0];

			$pieces = explode('@', $controller[1]);
			$class = $pieces[0];

			$methods = explode(',', $pieces[1]);

			for ($i = 0; $i < count($methods); $i++)
			{ 
				$type = isset($controller[2]) ? $controller[2] : $types[ $i ];

				if($i == 0)
					$arg = array('as' => $route, 'uses' => $class . '@' . $methods[$i] );
				else
					$arg = $class . '@' . $methods[$i];

				$return = Route::$type( $uri, $arg);

				foreach ($wheres as $search => $where)
				{
					if(strpos($uri, $search) > -1 || strpos($uri, str_replace('}', '?}', $search)) > -1)
					{
						$search = trim($search, '{}');
						$search = trim($search, '?');

						$return->where($search, $where);
					}
				}
			}
		}
	}
}