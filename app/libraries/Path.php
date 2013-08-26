<?php

class Path {

	protected $path;

	public static $baseUrl;
	public static $basePath;

	public function __construct( $path )
	{
		$this->path = $this->prepare( $path );
	}

	public static function setBase( $url, $basePath )
	{
		static::$baseUrl = $url;
		static::$basePath = $basePath;
	}

	public static function makeFromUrl( $url )
	{
		if( static::isLocal($url))
	
			return new Path(str_replace(static::$baseUrl, static::$basePath, $url));
	}


	public static function isLocal( $url )
	{
		return strpos($url, static::$baseUrl) > -1;
	}


	public function delete()
	{
		if(is_file($this->path)) {

			unlink($this->path);
		}
	}

	/**
	 * This method will create all directories along the way to 
	 * make sure this path does exists.
	 * This method might take a lot of time.. Don't use alot!
	 *
	 * @return void
	 */
	public function makeSureItExists( $permissions = 0755 )
	{
		$directories = explode($this->ds(), $this->escapeFile());

		$path = '';
		foreach ($directories as $directory)
		{
			$path .= $directory . $this->ds();

			if(! file_exists($path))

				mkdir( $path, $permissions );
		}
	}

	public function prepare( $path )
	{
		$path = str_replace('\\', $this->ds(), $path);
		$path = str_replace('/', $this->ds(), $path);

		return rtrim($path, '\\/');
	}

	public function ds()
	{
		return DIRECTORY_SEPARATOR;
	}

	public function escapeFile()
	{
		$pieces = explode($this->ds(), $this->getFull());

		array_pop($pieces);

		return implode($this->ds(), $pieces);
	}

	public function getFull()
	{
		return $this->path;
	}

	public function getUrl()
	{
		return $this->url;
	}

}