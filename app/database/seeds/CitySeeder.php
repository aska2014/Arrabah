<?php

use Address\City\City;

class CitySeeder extends Seeder {

	public function run()
	{
		$db = DB::table('cities')->getConnection()->getPdo();

		$sql = file_get_contents(app_path() . '/database/mysql/cities.sql');

		$db->exec('SET @@foreign_key_checks = 0');

		$qr = $db->exec($sql);

		$this->command->info('Cities have been created successfuly');
	}

}