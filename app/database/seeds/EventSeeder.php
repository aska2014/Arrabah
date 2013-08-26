<?php

use Membership\User\User;
use Social\Event\Event;
use Gallery\Image\Image;
use Gallery\Version\Version;

class EventSeeder extends Seeder {

	public function run()
	{
		DB::table('events')->delete();

		$users = User::all();

		$image = Image::create(array( 'title' => 'Image for event' ))
						->upload(Version::makeFromUrl(
							'http://www.arrabah.net/design/css/images/qotes.jpg',
							300, 
							195
						));

		$event = new Event(array(

			'title' => 'مولود جديد',
			'description' => 'بلا شيبلنمشستبس بتشسنبت س بتسيبت سنشيبت نست بنيست بشسي سشيب شسيب طوس بشسيب شسيب شيسب شسي ',
			'date_of_event' => '2013-08-24'

		));

		$users[0]->events()->save( $event );

		$event->image()->save( $image );

		$event->accept();

		$this->command->info('Events seeded for the first user');
	}

}