<?php namespace Membership\User;

use Datetime;
use DateInterval;
use MainAlgorithm;
use Website\Tracker\Tracker;

class Algorithm extends MainAlgorithm {

	public static $class = 'Membership\User\User';


	public static function onlineUsers( $query, $route, User $except = null)
	{
		$usersIds = \array_flatten(Tracker::online( $route )->get(array('user_id'))->toArray());

		if($except) unset($usersIds[array_search($except->id, $usersIds)]);

		if(empty($usersIds)) $usersIds[] = 0;
		
		return $query->whereIn('id', $usersIds);
	}
	

	public static function arrabah( $query )
	{
		return $query->where('from_arrabah', true);
	}

	public static function oldest( $query )
	{
		return $query->orderBy('day_of_birth', 'ASC');
	}

	public static function above18( $query )
	{
		return $query->where('day_of_birth', '<=', static::get18YearsBefore());
	}

	public static function below18( $query )
	{
		return $query->where('day_of_birth', '>', static::get18YearsBefore());
	}

	public static function search( $query, $keyword )
	{
		return $query->join('families', 'users.family_id', '=', 'families.id')
					 ->where(function($query) use ($keyword)
					 {
					 	$query->where('first_name', 'like', '%' . $keyword . '%')
							  ->orWhere('father_name', 'like', '%' . $keyword . '%')
							  ->orWhere('grand_father_name', 'like', '%' . $keyword . '%')
							  ->orWhere('families.name', 'like', '%' . $keyword . '%')
							  ->select('users.*')
							  ->distinct();
					 });
					 
	}


    public static function name($query, $first_name, $father_name, $family_name)
    {
        return $query->join('families', 'users.family_id', '=', 'families.id')
            ->where(function($query) use ($first_name, $father_name, $family_name)
            {
                if($first_name) $query->where('first_name', 'like', '%' . $first_name . '%');

                if($father_name) $query->where('father_name', 'like', '%' . $father_name . '%');

                if($family_name) $query->where('families.name', 'like', '%' . $family_name . '%');

                return $query->select('users.*')->distinct();
            });
    }

	public static function premium( $query )
	{
		return $query->where('type', User::PREMIUM);
	}

	public static function normal( $query )
	{
		return $query->where('type', User::NORMAL);
	}

    /**
     * Get all users except the given user
     *
     * @return Query
     */
    public static function except( $query, User $user )
    {
    	return $query->where('id', '!=', $user->id);
    }

    /**
     * Get accepted users
     *
     * @return Query
     */
    public static function accepted( $query )
    {
    	return $query->where('users.accepted', true);
    }

    /**
     * Get all users in this city
     *
     * @return Query
     */
    public static function byRegion( $query, $region_id )
    {
    	return $query->where('city_id', $region_id);
    }


	private static function get18YearsBefore()
	{
		$datetime = new Datetime;

		$datetime->sub(new DateInterval('P18Y'));

		return $datetime;
	}



}