<?php

class ScoreTableSeeder extends Seeder 
{

	public function run()
	{
		DB::table('score')->delete();

		# 1, 1, 4, false
		Score::create(array(
			'game_id' => 1,
			'user_id' => 1,
			'score' => 4,
			'winner' => false,
			'created_utc' => time()*1000
		));
		
		#1, 2, 5, true
		Score::create(array(
			'game_id' => 1,
			'user_id' => 2,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));

		#2, 1, 1, false
		Score::create(array(
			'game_id' => 2,
			'user_id' => 1,
			'score' => 1,
			'winner' => false,
			'created_utc' => time()*1000
		));

		#2, 2, 5, true
		Score::create(array(
			'game_id' => 2,
			'user_id' => 2,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));
		
		# 3, 1,2, false
		Score::create(array(
			'game_id' => 3,
			'user_id' => 1,
			'score' => 2,
			'winner' => false,
			'created_utc' => time()*1000
		));

		# 3, 2,5, true
		Score::create(array(
			'game_id' => 3,
			'user_id' => 2,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));
		
		# 4, 1,0, false
		Score::create(array(
			'game_id' => 4,
			'user_id' => 1,
			'score' => 0,
			'winner' => false,
			'created_utc' => time()*1000
		));
		
		# 4, 2,5, true
		Score::create(array(
			'game_id' => 4,
			'user_id' => 2,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));

		# 5, 1,6, true
		Score::create(array(
			'game_id' => 5,
			'user_id' => 1,
			'score' => 6,
			'winner' => true,
			'created_utc' => time()*1000
		));
		
		# 5, 2,5, false
		Score::create(array(
			'game_id' => 5,
			'user_id' => 2,
			'score' => 5,
			'winner' => false,
			'created_utc' => time()*1000
		));

		# 6, 1,5, true
		Score::create(array(
			'game_id' => 6,
			'user_id' => 1,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));
		
		# 6, 2,2, false
		Score::create(array(
			'game_id' => 6,
			'user_id' => 2,
			'score' => 2,
			'winner' => false,
			'created_utc' => time()*1000
		));

		# 7, 1,4, true
		Score::create(array(
			'game_id' => 7,
			'user_id' => 1,
			'score' => 4,
			'winner' => true,
			'created_utc' => time()*1000
		));
		
		# 7, 2,0, false
		Score::create(array(
			'game_id' => 7,
			'user_id' => 2,
			'score' => 0,
			'winner' => false,
			'created_utc' => time()*1000
		));

		# 8, 3, 4, false
		Score::create(array(
			'game_id' => 8,
			'user_id' => 3,
			'score' => 4,
			'winner' => false,
			'created_utc' => time()*1000
		));
		
		# 8, 2,5, true
		Score::create(array(
			'game_id' => 8,
			'user_id' => 2,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));

		# 9, 4,4, false
		Score::create(array(
			'game_id' => 9,
			'user_id' => 4,
			'score' => 4,
			'winner' => false,
			'created_utc' => time()*1000
		));
		
		# 9, 1,5, true
		Score::create(array(
			'game_id' => 9,
			'user_id' => 1,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));

		# 10, 4,5, true
		Score::create(array(
			'game_id' => 10,
			'user_id' => 4,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));

		# 10, 1,2, false
		Score::create(array(
			'game_id' => 10,
			'user_id' => 1,
			'score' => 2,
			'winner' => false,
			'created_utc' => time()*1000
		));

		# 11, 1,3, false
		Score::create(array(
			'game_id' => 11,
			'user_id' => 1,
			'score' => 3,
			'winner' => false,
			'created_utc' => time()*1000
		));
		
		# 11, 4,5, true
		Score::create(array(
			'game_id' => 11,
			'user_id' => 4,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));

		# 12, 1,5, true
		Score::create(array(
			'game_id' => 12,
			'user_id' => 1,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));
		
		# 12, 4,3, false
		Score::create(array(
			'game_id' => 12,
			'user_id' => 4,
			'score' => 3,
			'winner' => false,
			'created_utc' => time()*1000
		));

		# 13, 1,5, true
		Score::create(array(
			'game_id' => 13,
			'user_id' => 1,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));
		
		# 13, 3,4, false
		Score::create(array(
			'game_id' => 13,
			'user_id' => 3,
			'score' => 4,
			'winner' => false,
			'created_utc' => time()*1000
		));

		# 14, 3,5, true
		Score::create(array(
			'game_id' => 14,
			'user_id' => 3,
			'score' => 5,
			'winner' => true,
			'created_utc' => time()*1000
		));

		# 14, 4,2, false
		Score::create(array(
			'game_id' => 14,
			'user_id' => 4,
			'score' => 2,
			'winner' => false,
			'created_utc' => time()*1000
		));
		
	}

}