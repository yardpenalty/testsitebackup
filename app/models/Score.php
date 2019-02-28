<?php

class Score extends Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'score';

   	/**
	 * Let eloquent know that these attributes will be available for mass assignment
	 *
	 * @var string
	 */
	protected $fillable = array('user_id', 'game_id', 'score', 'winner', 'created_utc');

   	/**
	 * Get Last Game Score
	 *
	 * @var boolean
	 */
	public static function getLastGame()
	{
		$lastGame = DB::table('score')
			->select(DB::raw('*'))
    		->orderBy('id', 'desc')
    		->take(2)
    		->get();

    	return $lastGame;
	}

   	/**
	 * Insert new Score
	 *
	 * @var boolean
	 */
	public static function insertScore($user_id, $game_id, $score, $winner)
	{
		$success = DB::table('score')->insert(
			array(
				'user_id' => $user_id,
				'game_id' => $game_id,
				'score' => $score,
				'winner' => $winner,
				'created_utc' => (time()*1000),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
				)
			);

    	return $success;
	}
}