<?php

class Asset {

	/**
	 * Contain all js assets
	 *
	 * @var array
	 */
	protected static $jsAssets  = array();
	
	/**
	 * Contain all css assets
	 *
	 * @var array
	 */
	protected static $cssAssets = array();

	/**
	 * Plugins files to be loaded
	 *
	 * @var array
	 */
	protected static $plugins = array();

	/**
	 * Pages assets to be loaded
	 *
	 * @var array
	 */
	protected static $pages = array();

	/**
	 * Determines whether the assets files and plugins has
	 * been loaded.
	 *
	 * @var array
	 */
	protected static $loaded = false;

	/**
	 * Return server path to assets directory
	 *
	 * @todo
	 * @return string
	 */
	public static function assetsPath()
	{
		return app_path() . '/assets/';
	}

	/**
	 * Return server path to plugins directory
	 *
	 * @todo
	 * @return string
	 */
	public static function pluginsPath()
	{
		return static::assetsPath() . 'plugins/';
	}

	/**
	 * Add one more page to load its assets
	 *
	 * @param  string $plugin
	 * @return void
	 */
	public static function addPage( $page )
	{
		if(! in_array($page, static::$pages))

			static::$pages[] = $page;
	}

	/**
	 * Add one more plugin
	 *
	 * @param  string $plugin
	 * @return void
	 */
	public static function addPlugin( $plugin )
	{
		if(! in_array($plugin, static::$plugins))
	
			static::$plugins[] = $plugin;
	}

	/**
	 * Add plugins array
	 *
	 * @param  array $plugin
	 * @return void
	 */
	public static function addPlugins( $plugins )
	{
		foreach ($plugins as $plugin)
		{
			static::addPlugin( $plugin );
		}
	}

	/**
	 * Set the plugins assets files
	 *
	 * @param  array $files
	 * @return void
	 */
	public static function setPlugins( $plugins )
	{
		static::$plugins = $plugins;
	}

	/**
	 * Set the assets files
	 *
	 * @param  array $files
	 * @return void
	 */
	public static function setPages( $pages )
	{
		static::$pages = $pages;
	}

	/** 
	 * Load plugins and files
	 *
	 * @return void
	 */
	public static function load()
	{
		if(static::$loaded) return;

		static::$loaded = true;

		array_unshift(static::$pages, 'start');
		array_push   (static::$pages, 'end'  );

		static::loadPages();
		static::loadPlugins();
	}

	/**
	 * Load main files that contain the needed assets
	 *
	 * @return void
	 */
	private static function loadPages()
	{
		foreach (static::$pages as $page)
		{
			static::loadFile( static::assetsPath() . strtolower($page) . '.php' );
		}
	}

	/**
	 * Load plugins files that contain the needed assets
	 *
	 * @return void
	 */
	private static function loadPlugins()
	{
		foreach (static::$plugins as $plugin)
		{
			static::loadFile( static::pluginsPath() . strtolower($plugin) . '.php');
		}
	}

	/**
	 * Add new asset either to jsAssets or cssAssets depending on its extension
	 *
	 * @param  string $name
	 * @param  string $file
	 * @return void
	 */
	public static function add( $name, $file , $depend = '', $IE9 = false, $media = 'screen' )
	{
		$ext = pathinfo($file, PATHINFO_EXTENSION);

		switch ($ext)
		{
			case 'js':
				static::$jsAssets[] = compact('name', 'file', 'depend', 'IE9');
				static::organize( static::$jsAssets );
				break;
			
			case 'css':
				static::$cssAssets[] = compact('name', 'file', 'depend', 'media');
				static::organize( static::$cssAssets );
				break;
		}
	}

	/**
	 * Return JS 2D array
	 *
	 * @return array
	 */
	public static function getJS()
	{
		return static::$jsAssets;
	}

	/**
	 * Return Css 2D array
	 *
	 * @return array
	 */
	public static function getCSS()
	{
		return static::$cssAssets;
	}

	/**
	 * Return styles as html
	 *
	 * @return string
	 */
	public static function styles()
	{
		if(!static::$loaded) static::load();

		$html = '';
		foreach (static::$cssAssets as $array)
		{
			$html .= '<link rel="stylesheet" href="'.static::toURL($array['file']).'" media="'.$array['media'].'">'.PHP_EOL;
		}
		return $html;
	}

	/**
	 * Return scripts as html
	 *
	 * @return string
	 */
	public static function scripts()
	{
		if(!static::$loaded) static::load();

		$html = '';
		foreach (static::$jsAssets as $array)
		{
			if(! $array['IE9'])

				$html .= '<script src="'.static::toURL($array['file']).'"></script>'.PHP_EOL;

			else

				$html .= '<!--[if lt IE 9]>
							<script src="'.static::toURL($array['file']).'"></script>
						  <![endif]-->'.PHP_EOL;
		}
		return $html;
	}

	/**
	 * Organize array dependencies
	 *
	 * @todo   Multiple dependencies
	 * @param  array $array
	 * @return void
	 */
	public static function organize( &$array )
	{
		for ($i=0; $i < count($array) - 1; $i++)
		{ 
			for ($j=$i + 1; $j < count($array); $j++)
			{ 
				if( $array[ $i ]['depend'] == $array[ $j ]['name'] )
				{
					$tmp       = $array[$i];
					$array[$i] = $array[$j];
					$array[$j] = $tmp;
					break;
				}
			}
		}
	}

	/**
	 * Return full url to this asset
	 *
	 * @param  string $file_name
	 * @return string
	 */
	public static function toURL( $asset_path )
	{
		if(strpos($asset_path, '//') !== false)

			return $asset_path;
		
		return URL::asset( $asset_path );
	}

	public static function loadFile( $filename )
	{
		if(file_exists($filename))
			
			require $filename;
	}
}