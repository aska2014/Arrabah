<?php

use Gallery\Version\Version;
use Membership\Family\Family;
use Membership\User\User;

class FamilyUserSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();
		DB::table('families')->delete();

		$family = Family::create(array('name' => 'البحراوى', 'accepted' => true));

		$user = new User(array(
			'username' => 'كريم3د',
			'first_name' => 'كريم',
			'father_name' => 'محمد',
			'grand_father_name' => 'على',
			'telephone_no' => '01201109095',
			'email' => 'a.kareem_3d@yahoo.com',
			'age_days' => EasyDate::calculateAge(new Datetime('1991-08-24'))->days,
			'city_id' => 1035,
			'day_of_birth' => '1991-08-24',
			'place_of_birth' => 'بورسعيد',
			'accepted' => true
		));

		$user->password = Auth::hash( 'kareem123' );

		$family->users()->save( $user );

		// Create Version
		$version = Version::makeFromUrl('http://www.amdadjusters.org/amd/images/profileholder.gif', 122, 122);

		// Image uploader used to upload this image.
		$user->uploadProfile( $version );

		$this->command->info('Family and user seeded');
	}

}