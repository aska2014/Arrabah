<?php namespace Social\Job;

use Eloquent;
use Membership\User\User;
use Membership\Admin\Admin;

use AcceptableInterface;
use OwnedByUserInterface;

class Job extends Eloquent implements AcceptableInterface, OwnedByUserInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jobs';

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


    public static function byTitle($query, $title)
    {
        return $query->where('title', 'like', "%$title%")->orWhere('description', 'like', "%$title%");
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
     * Get latest jobs by the given user.
     *
     * @param  User $user
     * @param  int $num
     * @return Collection
     */
    public static function latestByUser( User $user, $num = 0 )
    {
        $query = $user->jobs()->orderBy('created_at', 'desc');

        return $num ? $query->take( $num ) : $query;
    }

    public function uploadImage( $versions )
    {
        $this->image()->create(array('title' => $this->title))->upload( $versions );
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
     * This has one image.
     *
     * @return Query
     */
    public function image()
    {
    	return $this->morphOne( 'Gallery\Image\Image', 'imageable' );
    }

    /**
     * This belongs to a user.
     *
     * @return Query
     */
    public function user()
    {
        return $this->belongsTo( 'Membership\User\User' );
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