<?php namespace Membership\Family;

use Eloquent;
use Illuminate\Support\Facades\DB;
use Membership\User\User;
use Membership\User\Algorithm as UserAlgorithm;

class Family extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'families';

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
    protected $softDelete = true;

    /**
     * @return mixed
     */
    public function getNumberOfUsersSmallerThan18()
    {
        return $this->users()->where('day_of_birth', '>=', DB::raw('CURDATE() - INTERVAL 18 YEAR'))->count();
    }

    /**
     * @return mixed
     */
    public function getNumberOfUsersGreaterThan18()
    {
        return $this->users()->where('day_of_birth', '<', DB::raw('CURDATE() - INTERVAL 18 YEAR'))->count();
    }

    /**
     * Get family by name
     * 
     * @param  string $name
     * @return Family
     */
    public static function getByName( $name )
    {
        return static::where('name', $name)->first();
    }

    /**
     * Get accepted families only
     *
     * @return Collection
     */
    public static function getAccepted()
    {
        return static::where('accepted', true)->get();
    }

    public function isAccepted()
    {
        return $this->accepted;
    }

    /**
     * Get accepted families only
     *
     * @return Collection
     */
    public static function getNotAccepted()
    {
        return static::where('accepted', false)->get();
    }

    /**
     * Get oldest member in this family
     *
     * @return User
     */
    public function getOldestUser()
    {
        return UserAlgorithm::oldest($this->users())->first();
    }

    /**
     * Image for this family
     *
     * @return Query
     */
    public function image()
    {
    	return $this->morphMany('Gallery\Image\Image', 'imageable');
    }

    /**
     * Get users for this family.
     *
     * @return Query
     */
    public function users()
    {
    	return $this->hasMany('Membership\User\User')->where('users.accepted', true);
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