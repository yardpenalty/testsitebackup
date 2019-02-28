<?php

class GameTableSeeder extends Seeder 
{

	public function run()
	{
		DB::table('game')->delete();

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

		Game::create(array(
			'created_utc' => time()*1000
		));

	}

}