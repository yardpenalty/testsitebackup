<?php

class UserTableSeeder extends Seeder 
{

	public function run()
	{
		DB::table('user')->delete();

		User::create(array(
			'user_name' => 'Alex',
			'email' => 'alex@zip.com',
			'password' => 'zip',
			'created_utc' => time()*1000
		));

		User::create(array(
			'user_name' => 'Barrett',
			'email' => 'barrett@zip.com',
			'password' => 'zip',
			'created_utc' => time()*1000
		));

		User::create(array(
			'user_name' => 'Joel',
			'email' => 'joel@zip.com',
			'password' => 'zip',
			'created_utc' => time()*1000
		));
		User::create(array(
			'user_name' => 'Tim',
			'email' => 'tim@zip.com',
			'password' => 'zip',
			'created_utc' => time()*1000
		));
	}

}