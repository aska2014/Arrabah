<?php namespace Website\Contact;

use Eloquent;

class Contact extends Eloquent {

	const QUESTION = 0;
	const SUGGESTION = 1;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contacts';

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
    protected $softDelete = true;

	/**
	 * One-to-Many relationship with user
	 *
	 * @return Query
	 */
	public function user()
	{
		return $this->belongsTo('Membership\User\User');
	}

    /**
     * Histories for this model.
     *
     * @return Query
     */
    public function histories()
    {
        return $this->morphMany('Website\History\History', 'historable');
    }

}