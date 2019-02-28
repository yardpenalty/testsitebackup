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

		// Seed User Table
		$this->call('UserTableSeeder');
		$this->command->info('User table seeded.');

		// Seed User Table
		$this->call('GameTableSeeder');
		$this->command->info('Game table seeded.');

		// Seed User Table
		$this->call('ScoreTableSeeder');
		$this->command->info('Score table seeded.');
	}

}
