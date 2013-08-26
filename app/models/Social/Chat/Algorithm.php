<?php namespace Social\Chat;

use MainAlgorithm;
use Datetime, DateInterval;

class Algorithm extends MainAlgorithm {

	public static $class = 'Social\Chat\Chat';

	public static function betweenFamily( $query, $familyId )
	{
		return $query->where('chatable_type', 'Membership\Family\Family')->where('chatable_id', $familyId);
	}


	public static function betweenUsers( $query, $fromId, $toId )
	{
		return $query->where('chatable_type', 'Membership\User\User')

		->where(function($query) use ($fromId, $toId)
		{
			$query->where(function($query) use($fromId, $toId)
			{
				$query->where('chatable_id', $toId)
					  ->orWhere('user_id', $fromId);

			})->orWhere(function($query) use($fromId, $toId)
			{
				$query->where('chatable_id', $fromId)
					  ->orWhere('user_id', $toId);
			});
		});
	}


	public static function newTabs( $query, $toId, array $notInIds )
	{
		$datetime = new Datetime;

		$datetime->sub(new DateInterval('PT5S'));

		$query = $query->where('chatable_type', 'Membership\User\User')
					   ->where('chatable_id',  $toId)
	   				   ->where('created_at', '>', $datetime);

	   	if( !empty($notInIds)) {

	   		return $query->whereNotIn('user_id', $notInIds);
	   	}

	   	return $query;
	}


	public static function idGreaterThanAndOrder( $query, $id )
	{
		return $query->where('id', '>', $id)->orderBy('id', 'DESC');
	}


	public static function betweenAll($query)
	{
		return $query->where('chatable_type', '');
	}

}