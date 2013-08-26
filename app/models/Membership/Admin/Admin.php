<?php namespace Membership\Admin;

use Eloquent;
use Voting\Question\Question;
use Voting\Answer\Answer;
use Voting\Vote\Vote;

use Membership\Family\Family;
use Membership\User\User;

use Social\Event\Event;
use Social\Job\Job;
use Social\Message\Message;

use Gallery\Gallery\Gallery;
use Gallery\Image\Image;

use Website\Contact\Contact;

use Membership\MemberInterface;

class Admin implements MemberInterface {

	public $id       = null;
	public $mail     = 'developer@arrabah.net';
	public $name     = 'إدارة موقع عرابة';
	public $password = 'kareem123';


	protected static $instance;

	private function __construct() {}

	public static function instance()
	{
		if(! static::$instance) {

			static::$instance = new Admin;
		}

		return static::$instance;
	}

    /**
     * Return true if this member is the same as the given one
     *
     * @param  User $user
     * @return boolean
     */
    public function same( MemberInterface $user )
    {
    	return false;
    }

    /**
     * Upload profile image.
     *
     * @param  array $versions
     * @return void
     */
    public function uploadProfile( $versions )
    {
    	//
    }

	/**
	 * Get first and family name for the user.
	 * 
	 * @return string
	 */
	public function getTwoName()
	{
		return $this->name;
	}

	/**
	 * Vote for a question with an answer.
	 *
	 * @param  Question $question
	 * @param  Answer   $answer
	 * @return void
	 */
	public function voteFor( Question $question, Answer $answer )
	{
		//
	}

	/**
	 * Get family for this user
	 *
	 * @return Query
	 */
	public function family()
	{
		return Family::whereNull('id');
	}

	/**
	 * Get city for this user.
	 *
	 * @return Query
	 */
	public function city()
	{
		return User::whereNull('id');
	}

	/**
	 * Get profile image for this user
	 *
	 * @return Query
	 */
	public function images()
	{
		return Image::whereNull('user_id');
	}

	/**
	 * Get profile image for this user
	 *
	 * @return Query
	 */
	public function profileImage()
	{
		return Image::whereNull('user_id')->take(1);
	}

	/**
	 * Get galleries for this user
	 *
	 * @return Query
	 */
	public function galleries()
	{
		return Gallery::whereNull('user_id');
	}

	/**
	 * Get votes for this user on different questions
	 *
	 * @return Query
	 */
	public function votes()
	{
		return Vote::whereNull('user_id');
	}

	/**
	 * Get events this user created
	 *
	 * @return Query
	 */
	public function events()
	{
		return Event::whereNull('user_id');
	}

	/**
	 * Many relationship with contactus
	 *
	 * @return Query
	 */
	public function contacts()
	{
		return Contact::whereNull('user_id');
	}

	/**
	 * This user has many jobs.
	 *
	 * @return Query
	 */
	public function jobs()
	{
		return Job::whereNull('user_id');
	}

	/**
	 * Get received messages
	 *
	 * @return Query
	 */
	public function receivedMessages()
	{
		return Message::where('id', '=', 0);
	}

	/**
	 * Get messages this user sent
	 *
	 * @return Query
	 */
	public function sentMessages()
	{
		return Message::where('id', '=', 0);
	}

	/**
	 *
	 *
	 * @return mixed
	 */
	public function __get( $property )
	{
		if(method_exists($this, $property)) {

			return $this->$property()->get();
		}

		return '';
	}

	public function __call( $method, $args )
	{
		return $this;
	}

}