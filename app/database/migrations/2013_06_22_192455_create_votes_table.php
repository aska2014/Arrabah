<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

			$table->integer('question_id')->unsigned();
			$table->foreign('question_id')->references('id')->on('questions')->onDelete('CASCADE');

			$table->integer('answer_id')->unsigned();
			$table->foreign('answer_id')->references('id')->on('answers')->onDelete('CASCADE');

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
		Schema::drop('votes');
	}

}
