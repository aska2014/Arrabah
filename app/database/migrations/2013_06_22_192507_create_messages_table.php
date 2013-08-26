<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->string('title');
			$table->text('description');

			$table->boolean('seen')->default(false);

			// Nullable because it can be from controlpanel
			$table->integer('from_id')->unsigned()->nullable();
			$table->foreign('from_id')->references('id')->on('users')->onDelete('CASCADE');

			$table->integer('to_id')->unsigned();
			$table->foreign('to_id')->references('id')->on('users')->onDelete('CASCADE');

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
		Schema::drop('messages');
	}

}
