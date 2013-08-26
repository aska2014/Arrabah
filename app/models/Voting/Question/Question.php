<?php namespace Voting\Question;

use Membership\User\User;
use Eloquent;

class Question extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'questions';

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
     * Get question not voted by this user
     *
     * @param  User $user
     * @return Query
     */
    public static function notVotedBy( User $user )
    {
        $questions_ids = $user->votes()->get(array('question_id'))->toArray();

        $questions_ids = \array_flatten($questions_ids);

        if(! empty($questions_ids))

            return static::whereNotIn( 'id', $questions_ids )->orderBy('id', 'DESC');

        return static::where('id', '!=', 0)->orderBy('id', 'DESC');
    }

    /**
     * Return the answers this belongs to.
     *
     * @return Query
     */
    public function answers()
    {
    	return $this->hasMany('Voting\Answer\Answer');
    }

    /**
     * Get all votes for this question
     *
     * @return Query
     */
    public function votes()
    {
        return $this->hasMany('Voting\Vote\Vote');
    }

    /**
     * Get latest question
     *
     * @param  int $num
     * @return Event
     */
    public static function latest( $num )
    {
    	return static::orderBy('created_at', 'desc');
    }
}