<?php namespace Social\Message;

use Eloquent;

use Membership\Admin\Admin;
use Membership\User\User;
use Membership\MemberInterface;

class Message extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'messages';

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
     * Count all messages not seen by this user
     *
     * @return Query
     */
    public static function countNotSeenMessages( MemberInterface $user )
    {
        return static::where('to_id', $user->id)->where('seen', false)->get(array('id'))->count();
    }

    /**
     * Send message from one user to another.
     *
     * @param  User $from
     * @param  User $to
     * @return void
     */
    public function send( MemberInterface $from, MemberInterface $to )
    {
        $this->from_id = $from->id;
        $this->to_id   = $to->id;

        $this->save();
    }

    /**
     * Determine whether the message have been seen or not.
     *
     * @return boolean
     */
    public function isSeen()
    {
        return $this->seen;
    }

    /**
     * Determine if this message is sent to the given user
     *
     * @param  User $user
     * @return boolean
     */
    public function isTo( MemberInterface $user )
    {
        return $this->to_id == $user->id;
    }


    /**
     * Make all messages to be seen
     *
     * @return void
     */
    public static function makeSeen( $query )
    {
        $query->update(array('seen' => true));
    }

    /**
     * Get user that sent this message.
     *
     * @return User
     */
    public function getFromUser()
    {
        return User::find( $this->from_id )?: Admin::instance();
    }   

    /**
     * Get user that this message was sent to.
     *
     * @return User
     */
    public function getToUser()
    {
        return User::find( $this->to_id );
    }

    /**
     * Get messages that was sent by the given user
     *
     * @param  Membership\User\User $user
     * @return Query
     */
    public static function from( $user )
    {
    	return static::where('from_id', $user->id)->orderBy('created_at', 'DESC');
    }

    /**
     * Get messages that was received by the given user
     *
     * @param  Membership\User\User $user
     * @return Collection
     */
    public static function to( $user )
    {
    	return static::where('to_id', $user->id)->orderBy('created_at', 'DESC');
    }

}