<?php

use Website\Page\Page;
use Website\Place\Place;
use Website\Content\Content;

class ContentPlaceSeeder extends Seeder {

	public function run()
	{
		DB::table('contents')->delete();
		DB::table('places')->delete();
		DB::table('pages')->delete();

		// Create all places
		Place::createAll();

		// Get home_welcome place
		$place = Place::getByIdentifier('home_welcome');

		// Create content and attach place
		Content::create(array(
			'title' => 'رسالة ترحيبية',
			'description' => 'شسيبيسب شسيب شسب شيسبن شسيبت شسايبت شسابت يسابا تشساب شستبا شستبا شستبا شستيا بشيست باشستبا شستبا شستبا شست بشتيسا تب شستا بشستبا ت سي.'
		))->places()->save($place);
		
		// Create page and attach place
		Page::create(array(
			'english_title' => 'arrabah in lines', 
			'title' => 'عرابة فى سطور'
		))->places()->save($place);

		$this->command->info('Content, page and place have been created successfuly');
	}

}