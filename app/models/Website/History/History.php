<?php namespace Website\History;

use Eloquent;

class History extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'histories';

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
     * Get user for this history.
     *
     * @return Query
     */
    public function user()
    {
    	return $this->belongsTo( 'Membership\User\User' );
    }

    /**
     * Return a query with the model it's morphed to.
     *
     * @return Query
     */
    public function historable()
    {
    	return $this->morphTo();
    }
}