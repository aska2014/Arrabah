<?php namespace Social\Chat;

use Eloquent;

class Chat extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'chats';

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
     * Check if this chat message is attached to family.
     *
     * @return boolean
     */
    public function attachedToFamily()
    {
    	return $this->chatable_type == 'Membership\Family\Family';
    }

    /**
     * Check if this chat message is attached to family.
     *
     * @return boolean
     */
    public function attachedToUser()
    {
    	return $this->chatable_type == 'Membership\User\User';
    }

    /**
     * Check if this chat message is attached to family.
     *
     * @return boolean
     */
    public function attachedToAll()
    {
    	return $this->chatable_type == '';
    }

    /**
     * User sent this chat message.
     *
     * @return Query
     */
    public function user()
    {
    	return $this->belongsTo('Membership\User\User');
    }

    /**
     * Get attached to this chat.
     *
     * @return Query
     */
    public function chatable()
    {
    	return $this->morphTo();
    }
}