<?php

use Intervention\Image\Image as ImageUploader;

class ImageConfig {

	/**
	 * Path for this Image configuration.
	 *
	 * @var string 
	 */
	protected $path;

	/**
	 * Manipulater of the image.
	 *
	 * @var Closure
	 */
	protected $manipulator;

	/**
	 * Constructor.
	 *
	 * @param  array $settings
	 * @return void
	 */
	public function __construct( $path )
	{
		$this->path = $path;
	}

	/**
	 * Factory method.
	 *
	 * @param  string $path
	 * @return ImageConfig
	 */
	public static function make( $path )
	{
		return new static( $path );
	}

	/**
	 * Get version
	 *
	 * @param  Closure $imageUploader
	 * @return ImageConfig (fluent interface)
	 */
	public function manipulate( $closure )
	{
		$this->manipulator = $closure;

		return $this;
	}

	/**
	 * Get manipulator.
	 *
	 * @return Closure
	 */
	public function getManipulator()
	{
		return $this->manipulator;
	}

	/**
	 * Get destination by replacing between brackets
	 *
	 * @param  array $replacers
	 * @return stirng
	 */
	public function getDestinationUrl( array $replacers = array() )
	{
		return AlbumsManager::albums(\replace_all($this->path, $replacers));
	}

	/**
	 * Get path for this image
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Get extension for this image
	 *
	 * @return string
	 */
	public function getExtension()
	{
		$info = pathinfo($this->path);

		return $info['extension'];
	}

}