<?php namespace Website\Content;

use Eloquent;
use Websiet\Place\Place;

class Content extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contents';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('id');

	/**
	 * The attributes that can't be mass assigned
	 *
	 * @var array
	 */
    protected $guarded = array('id');

    /**
     * Whether or not to softDelete
     *
     * @var bool
     */
    protected $softDelete = false;

    /**
     * Return page for this content.
     *
     * @return Query
     */
    public function getPage()
    {
        return $this->place ? $this->place->page : null;
    }

    /**
     * Has many places
     *
     * @return Query
     */
    public function places()
    {
    	return $this->morphMany('Website\Place\Place', 'placeable');
    }

    /**
     * Return true if this content has place
     *
     * @return bool
     */
    public function inPlace( $identifier )
    {
        foreach ($this->places as $place)
        {
            if($place->is($identifier))

                return true;
        }
        
        return false;
    }

}