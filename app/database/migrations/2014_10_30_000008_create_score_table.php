<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('score', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->integer('game_id');
			$table->integer('score');
			$table->boolean('winner');
			$table->bigInteger('created_utc');
			$table->timestamps();

			$table->index('user_id');
			$table->index('game_id');
			$table->index('score');
			$table->index('winner');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('score');
	}

}
