<?php

use Membership\Family\Family;

use Membership\User\User;
use Membership\User\Algorithm as UserAlgorithm;

use Website\Tracker\Tracker as Tracking;

class OnlineController extends BaseController {


	public function updateOnline( $route )
	{
		Tracking::add(Auth::user(), $route);
	}


	public function getOnlineUsers( $route )
	{
		if($family = Family::find(Input::get('family', 0)))

			$usersQuery = $family->users();

		else

			$usersQuery = User::query();

		$allUsers = UserAlgorithm::onlineUsers($usersQuery, $route, Auth::user())->get();

		$users = array();

		foreach ($allUsers as $user)
		{
			$users[] = array(
				'id'    => $user->id,
				'name'  => $user->getTwoName2(),
				'image' => $user->profileImage->getUrl( 60, 60 ),
				'url'   => URL::profile($user)
			);
		}

		return Response::json($users);
	}

}