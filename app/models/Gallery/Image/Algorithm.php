<?php namespace Gallery\Image;

use DB, MainAlgorithm;

class Algorithm extends MainAlgorithm {

	public static $class = 'Gallery\Image\Image';

	public static function random( $query )
	{
		return $query->orderBy(DB::raw('RAND()'));
	}

	public static function attachedToGallery( $query )
	{
		return $query->where('imageable_type', 'Gallery\Gallery\Gallery');
	}
}

