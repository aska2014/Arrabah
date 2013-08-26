<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('ContentPlaceSeeder');

		$this->call('CitySeeder');
		
		$this->call('FamilyUserSeeder');

		$this->call('EventSeeder');

		$this->call('QuestionAnswerSeeder');

	}
}