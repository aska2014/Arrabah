<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('galleries', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->string('title');
			$table->text('description');

			$table->boolean('accepted')->default(false);

			$table->integer('gallerable_id')->unsigned();
			$table->string('gallerable_type');

			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

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
		Schema::drop('galleries');
	}

}
