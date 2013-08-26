<?php namespace Website\Link;

use Eloquent;

class Link extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'links';

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
     * Use timestampe
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Image for this link if exists
     *
     * @return Query
     */
    public function image()
    {
    	return $this->morphOne('Gallery\Image\Image', 'imageable');
    }

}