<?php namespace Membership;

use Voting\Question\Question;
use Voting\Answer\Answer;

interface MemberInterface {

    /**
     * Return true if this member is the same as the given one
     *
     * @param  User $user
     * @return boolean
     */
    public function same( MemberInterface $user );

    /**
     * Upload profile image.
     *
     * @param  array $versions
     * @return void
     */
    public function uploadProfile( $versions );

	/**
	 * Get first and family name for the user.
	 * 
	 * @return string
	 */
	public function getTwoName();

	/**
	 * Vote for a question with an answer.
	 *
	 * @param  Question $question
	 * @param  Answer   $answer
	 * @return void
	 */
	public function voteFor( Question $question, Answer $answer );

	/**
	 * Get family for this user
	 *
	 * @return Query
	 */
	public function family();

	/**
	 * Get city for this user.
	 *
	 * @return Query
	 */
	public function city();

	/**
	 * Get profile image for this user
	 *
	 * @return Query
	 */
	public function images();

	/**
	 * Get profile image for this user
	 *
	 * @return Query
	 */
	public function profileImage();

	/**
	 * Get galleries for this user
	 *
	 * @return Query
	 */
	public function galleries();

	/**
	 * Get votes for this user on different questions
	 *
	 * @return Query
	 */
	public function votes();

	/**
	 * Get events this user created
	 *
	 * @return Query
	 */
	public function events();

	/**
	 * Many relationship with contactus
	 *
	 * @return Query
	 */
	public function contacts();

	/**
	 * This user has many jobs.
	 *
	 * @return Query
	 */
	public function jobs();

	/**
	 * Get received messages
	 *
	 * @return Query
	 */
	public function receivedMessages();

	/**
	 * Get messages this user sent
	 *
	 * @return Query
	 */
	public function sentMessages();
}