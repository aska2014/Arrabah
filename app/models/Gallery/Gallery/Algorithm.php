<?php namespace Gallery\Gallery;

use DB;
use MainAlgorithm;
use Gallery\Image\Image;

class Algorithm extends MainAlgorithm {

    public static $class = 'Gallery\Gallery\Gallery';

	public static function getRandomAttachedToUser()
	{
		return Gallery::where('gallerable_type', 'Membership\User\User')
						->orderBy(DB::raw('RAND()'));
	}


    public static function getAttachedToUser( $query )
    {
        return $query->where('gallerable_type', 'Membership\User\User');
    }

    /**
     * Get random gallery
     *
     * @return Query
     */
    public static function getRandom( $query )
    {
        return static::orderBy(DB::raw('RAND()'));
    }

    /**
     * Get random gallery
     *
     * @return Query
     */
    public static function accepted( $query )
    {
        return $query->where('accepted', true);
    }

    /**
     *
     *
     * @return Collection
     */
    public static function hasImages( $query )
    {
        return $query->get()->filter(function( $gallery )
        {
            return $gallery->hasImages();
        });
    }

}