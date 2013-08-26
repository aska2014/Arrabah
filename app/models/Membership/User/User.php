<?php namespace Membership\User;

use Eloquent;

use Gallery\Image\Image;

use Voting\Vote\Vote;
use Voting\Question\Question;
use Voting\Answer\Answer;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

use Social\Message\Message;

use AcceptableInterface;
use Membership\MemberInterface;

class User extends Eloquent implements UserInterface, RemindableInterface, AcceptableInterface, MemberInterface {

	const NORMAL = 1325;
	const PREMIUM = 8465;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('id', 'password', 'age_days', 'accepted', 'deleted_at', 'family_id', 'city_id');

	/**
	 * The attributes that can't be mass assigned
	 *
	 * @var array
	 */
    protected $guarded = array('id', 'password');

    /**
     * Whether or not to softDelete
     *
     * @var bool
     */
    protected $softDelete = true;

    /**
     * Get user by email
     *
     * @param  string $email
     * @return User
     */
    public static function getByEmail( $email )
    {
    	return User::where('email', $email)->first();
    }

    /**
     * Accept current object.
     *
     * @return void
     */
    public function accept()
    {
        $this->accepted = true;

        $this->save();
    }

    /**
     * Unaccept current object.
     *
     * @return void
     */
    public function unaccept()
    {
        $this->accepted = false;

        $this->save();
    }

    /**
     * Throws an exception if not accepted
     *
     * @throws NotAcceptedException
     * @return void
     */
    public function failIfNotAccepted()
    {
        if(! $this->accepted)

            throw new \NotAcceptedException;
    }

    /**
     * Determines if this user is from arrabah.
     *
     * @return bool
     */
    public function fromArrabah()
    {
    	return $this->from_arrabah;
    }

    /**
     * Determines if this user is premium.
     *
     * @return bool
     */
    public function isPremium()
    {
    	return $this->type == static::PREMIUM;
    }

    /**
     * Make this user premium.
     *
     * @return void
     */
    public function makePremium()
    {
    	$this->type = static::PREMIUM;

    	$this->save();
    }

    /**
     * Same User.
     *
     * @param  MemberInterface $user
     * @return bool
     */
    public function same( MemberInterface $user )
    {
    	return $user->id == $this->id;
    }

    /**
     * Upload profile image.
     *
     * @param  array $versions
     * @return void
     */
    public function uploadProfile( $versions )
    {
    	$image = Image::create(array('title' => 'الصورة الشخصية للعضو: ' . $this->getTwoName(), 'accepted' => true));

    	$image->upload($versions);

    	// Say that the user created this image
    	$this->images()->save( $image );

    	// Set this as the profile image
    	$this->profileImage()->save( $image );
    }

	/**
	 * Get the unique identifier for the user.
	 * 
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Get token to identify this user.
	 *
	 * @return stirng
	 */
	public function getToken()
	{
		return $this->password;
	}

	/**
	 * Validate user token.
	 *
	 * @param  string $token
	 * @return boolean
	 */
	public function validateToken( $token )
	{
		return $this->getToken() == $token;
	}

	/**
	 * Get first and family name for the user.
	 * 
	 * @return string
	 */
	public function getTwoName()
	{
		if(! $this->family)

			return $this->getTwoName2();
		
		return $this->first_name . ' ' . $this->family->name;
	}

	/**
	 * Get first and family name for the user.
	 * 
	 * @return string
	 */
	public function getTwoName2()
	{
		return $this->first_name . ' ' . $this->father_name;
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
		$vote = new Vote();

		$vote->question()->associate( $question );
		$vote->answer()->associate( $answer );
		$vote->user()->associate( $this );

		$vote->save();
	}

	/**
	 * Get family for this user
	 *
	 * @return Query
	 */
	public function family()
	{
		return $this->belongsTo( 'Membership\Family\Family' );
	}

	/**
	 * Get city for this user.
	 *
	 * @return Query
	 */
	public function city()
	{
		return $this->belongsTo('Address\City\City');
	}

	/**
	 * Get images this user created
	 *
	 * @return Query
	 */
	public function images()
	{
		return $this->hasMany('Gallery\Image\Image');
	}

	/**
	 * Get images this user created
	 *
	 * @return Query
	 */
	public function profileImage()
	{
		return $this->morphOne('Gallery\Image\Image', 'imageable');
	}

	/**
	 * Get galleries for this user
	 *
	 * @return Query
	 */
	public function galleries()
	{
		return $this->hasMany('Gallery\Gallery\Gallery');
	}

	/**
	 * Get votes for this user on different questions
	 *
	 * @return Query
	 */
	public function votes()
	{
		return $this->hasMany('Voting\Vote\Vote');
	}

	/**
	 * Get events this user created
	 *
	 * @return Query
	 */
	public function events()
	{
		return $this->hasMany('Social\Event\Event');
	}

	/**
	 * This user has many jobs.
	 *
	 * @return Query
	 */
	public function jobs()
	{
		return $this->hasMany('Social\Job\Job');
	}

	/**
	 * Get received messages
	 *
	 * @return Query
	 */
	public function receivedMessages()
	{
		return Message::to( $this );
	}

	/**
	 * Get messages this user sent
	 *
	 * @return Query
	 */
	public function sentMessages()
	{
		return Message::from( $this );
	}

	/**
	 * Many relationship with contactus
	 *
	 * @return Query
	 */
	public function contacts()
	{
		return $this->hasMany('Website\Contact\Contact');
	}

    /**
     * Histories for this model.
     *
     * @return Query
     */
    public function histories()
    {
        return $this->hasMany('Website\History\History');
    }

    /**
     * Trackers for this user.
     *
     * @return Query
     */
    public function trackers()
    {
        return $this->hasMany('Website\Tracker\Tracker');
    }

    /** 
     * Many relationship with chats.
     *
     * @return Query
     */
    public function ownedChats()
    {
    	return $this->hasMany('Social\Chat\Chat');
    }

    /** 
     * Many relationship with chats.
     *
     * @return Query
     */
    public function chats()
    {
    	return $this->morphMany('Social\Chat\Chat', 'chatable');
    }
}