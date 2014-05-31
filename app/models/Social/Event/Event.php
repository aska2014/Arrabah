<?php namespace Social\Event;

use Eloquent;
use Membership\User\User;
use Gallery\Image\Image;

use Membership\Admin\Admin;

use AcceptableInterface;
use OwnedByUserInterface;

class Event extends Eloquent implements AcceptableInterface, OwnedByUserInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';

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
     * Accept current object.
     *
     * @return void
     */
    public function accept()
    {
        if($image = $this->image)

            $image->accept();

        if($gallery = $this->gallery)

            $gallery->accept();

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
        if($image = $this->image)

            $image->unaccept();

        if($gallery = $this->gallery)

            $gallery->unaccept();

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


    public static function getAccepted( $query )
    {
        return $query->where('accepted', true);
    }

    /**
     * Get latest event
     *
     * @param  int $num
     * @return Query
     */
    public static function latest( $num = 0 )
    {
        $query = static::orderBy('created_at', 'desc');

        return $num ? $query->take( $num ) : $query;
    }


    /**
     * Get latest events by the given user.
     *
     * @param  User $user
     * @param  int $num
     * @return Collection
     */
    public static function latestByUser( User $user, $num = 0 )
    {
        $query = $user->events()->orderBy('created_at', 'desc');

        return $num ? $query->take( $num ) : $query;
    }

    public function uploadImage( $versions )
    {
        return $this->image()->create(array('title' => $this->title, 'accepted' => true))->upload( $versions );
    }

    /**
     * Get user for this object.
     *
     * @return MemberInterface
     */
    public function getUser()
    {
        return $this->user ?: Admin::instance();
    }

    /**
     * Get gallery for this event.
     *
     * @return void
     */
    public function gallery()
    {
        return $this->morphOne( 'Gallery\Gallery\Gallery', 'gallerable');
    }

    /**
     * Get image for this event
     *
     * @return Query
     */
    public function image()
    {
        return $this->morphOne( 'Gallery\Image\Image', 'imageable' );
    }

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->morphMany('Social\Comment\Comment', 'commentable');
    }

    /**
     * Belongs to user.
     *
     * @return Query
     */
    public function user()
    {
    	return $this->belongsTo('Membership\User\User');
    }

    /**
     * Get date for this event
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date_of_event;
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