<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('user_name', 40);
			$table->string('email', 75);
			$table->string('password', 40);
			$table->bigInteger('created_utc');
			$table->timestamps();
			
			$table->unique('user_name');
			$table->index('user_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
	}

}
