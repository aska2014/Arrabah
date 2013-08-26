<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Membership\User\User;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');

			$table->string('first_name');
			$table->string('father_name');
			$table->string('grand_father_name');

			$table->string('username');
			$table->string('email');
			$table->string('password');

			$table->string('sex')->default('male');
			$table->integer('age_days');
			$table->date('day_of_birth');
			$table->string('place_of_birth');
			$table->string('telephone_no');

			$table->boolean('accepted');
			$table->smallInteger('type')->default(User::NORMAL);
			
			$table->softDeletes();

			$table->integer('family_id')->unsigned();
			$table->foreign('family_id')->references('id')->on('families')->onDelete('CASCADE');

			$table->integer('city_id')->unsigned()->nullable();
			$table->foreign('city_id')->references('id')->on('cities')->onDelete('CASCADE');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
