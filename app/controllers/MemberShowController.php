<?php

use Membership\Family\Family;
use Membership\User\Algorithm as UserAlgorithm;

class MemberShowController extends BaseController {



	public function normalUsers()
	{
		$familyUsers = $this->filterUsers(
			
			UserAlgorithm::query()

		)->paginate( 12 );

		$membersTitle = 'أعضاء شرف';

		return View::make('families.members2', compact('familyUsers', 'membersTitle'));
	}




	public function premiumUsers()
	{
		$familyUsers = $this->filterUsers(
		
			UserAlgorithm::premium(UserAlgorithm::query())

		)->paginate( 12 );

		$membersTitle = 'أعضاء مشاركة';

		return View::make('families.members2', compact('familyUsers', 'membersTitle'));
	}




	public function arrabahUsers()
	{
		$familyUsers = $this->filterUsers(
		
			UserAlgorithm::arrabah(UserAlgorithm::query())

		)->paginate( 12 );

		$membersTitle = 'أبناء البلد';

		return View::make('families.members2', compact('familyUsers', 'membersTitle'));
	}



	public function families()
	{
		$families = Family::all();
//
//        $tt = 'أاإآ,ب,ت,ث,ج,ح،خ،د،ذ،ر،ز,س،ش،ص،ض،طـ،ظ،ع،غ،ف،ق،ك،ل،م،ن،ه،و،ي';
//
//        $families->sort(function($a, $b) use($tt)
//        {
//            $a1 = substr($a->name, 0, 1);
//            $b1 = substr($b->name, 0, 1);
//
//            return strpos($tt, $a1) >= strpos($tt, $b1);
//        });

        $tolt = ceil($families->count() / 3);

		return View::make('families.design2', compact('families', 'tolt'));
	}




	public function search()
	{
		$keyword = Input::get('keyword');

		$familyUsers = $this->filterUsers(
		
			UserAlgorithm::search(UserAlgorithm::query(), $keyword)

		)->paginate( 12 );

		$membersTitle = 'بحث عن عضو بكلمة: ' . $keyword;

		return View::make('families.members', compact('familyUsers', 'membersTitle'));
	}






	public function family( $id )
	{
		$family = Family::findOrFail( $id );

		$familyUsers = $this->filterUsers($family->users())->with('family')->get();

		$membersTitle = $family->name;

		return View::make('families.members3', compact('familyUsers', 'membersTitle'));
	}






	private function filterUsers( $query )
	{
		if(Input::get('age') == 'above-18') {

			$query = UserAlgorithm::above18( $query );
		} 
		elseif(Input::get('age') == 'below-18') {

			$query = UserAlgorithm::below18( $query );
		}

		return UserAlgorithm::accepted($query);
	}
}