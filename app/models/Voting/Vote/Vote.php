<?php namespace Voting\Vote;

use Eloquent;
use Membership\User\User;

use Voting\Answer\Answer;
use Voting\Question\Question;

class Vote extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'votes';

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
     * Determines whether the user have voted for this question
     *
     * @param  User     $user
     * @param  Question $question
     * @return boolean
     */
    public static function hasVoted( User $user, Question $question )
    {
        return ! $user->votes()->where('question_id', $question->id)->get(array('id'))->isEmpty();
    }


    public static function allVotesWithUser( $answerOrQuestion )
    {
        if($answerOrQuestion instanceof Answer)

            return static::where('answer_id', $answerOrQuestion->id)->with('user')->get();

        elseif($answerOrQuestion instanceof Question)

            return static::where('question_id', $answerOrQuestion->id)->with('user')->get();
  
    }

    public static function count( $answerOrQuestion )
    {
        if($answerOrQuestion instanceof Answer)
 
           return static::where('answer_id', $answerOrQuestion->id)->get(array('id'))->count();

       elseif($answerOrQuestion instanceof Question)

            return static::where('question_id', $answerOrQuestion->id)->get(array('id'))->count();
    }

    /**
     * Return the answer this belongs to.
     *
     * @return Query
     */
    public function answer()
    {
    	return $this->belongsTo('Voting\Answer\Answer');
    }

    /**
     * Get question for this vote.
     *
     * @return Query
     */
    public function question()
    {
        return $this->belongsTo('Voting\Question\Question');
    }

    /**
     * Return the answer this belongs to.
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