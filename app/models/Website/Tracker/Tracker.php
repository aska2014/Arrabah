<?php namespace Website\Tracker;

use Membership\User\User;
use Eloquent;
use Datetime, DateInterval;

class Tracker extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tracker';

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
     * Add tracker.
     *
     * @param  User   $user
     * @param  string $route
     * @return void
     */
    public static function add( User $user, $route )
    {
    	if($user->trackers()->first(array('id')))

    		$user->trackers()->update(compact('route'));

    	else

    		$user->trackers()->create(compact('route'));
    }

    /**
     * Get all users for this route.
     *
     * @return Query
     */
    public static function online( $route )
    {
        $datetime = new Datetime();

        $datetime = $datetime->sub(new DateInterval('PT4S'));

        return static::where('route', $route)->where('updated_at', '>', $datetime);
    }


    /**
     * User for this tracker.
     *
     * @return Query
     */
    public function user()
    {
        return $this->belongsTo('Membership\User\User');
    }
}