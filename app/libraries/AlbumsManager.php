<?php

use Gallery\Version\Version;

class AlbumsManager {


	public static function defaultImage( $model )
	{
		return static::albums(Config::get('images.defaults.' . $model));
	}


	public static function albums( $path )
	{
		return Path::$baseUrl . '/albums/' . $path;
	}
	

	public static function validate( $image )
	{
		return !($image == null || ! in_array($image->getClientMimeType(), array(
		        // images
		        'png' => 'image/png',
		        'jpe' => 'image/jpeg',
		        'jpeg' => 'image/jpeg',
		        'jpg' => 'image/jpeg',
		        'gif' => 'image/gif',
		        'bmp' => 'image/bmp',
		        'ico' => 'image/vnd.microsoft.icon',
		        'tiff' => 'image/tiff',
		        'tif' => 'image/tiff',
		        'svg' => 'image/svg+xml',
		        'svgz' => 'image/svg+xml',
		)));
	}


	public static function getVersions( array $imageConfigs, $source, $replacers = array() )
	{
		$versions = array();

		foreach ($imageConfigs as $imageConfig)
		{
			$version = Version::makeFromFile($source, $imageConfig->getDestinationUrl($replacers));

			$versions[] = $version->manipulate($imageConfig->getManipulator());
		}

		return $versions;
	}

}