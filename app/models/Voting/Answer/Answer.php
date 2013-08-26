<?php namespace Voting\Answer;

use Eloquent;

class Answer extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'answers';

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
     * Return the question this belongs to.
     *
     * @return Query
     */
    public function question()
    {
    	return $this->belongsTo('Voting\Question\Question');
    }


    /**
     * Return all votes for this answer.
     *
     * @return Query
     */
    public function votes()
    {
    	return $this->hasMany('Voting\Vote\Vote');
    }
}