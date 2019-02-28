<?php

class Game extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'game';

   	/**
	 * Let eloquent know that these attributes will be available for mass assignment
	 *
	 * @var string
	 */
	protected $fillable = array('created_utc');	

   	/**
	 * Insert new Score
	 *
	 * @var boolean
	 */
	public static function insertGame()
	{
		date_default_timezone_set('UTC');
		$success = DB::table('game')->insert(
			array(
				'created_utc' => (time()*1000),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
				)
			);

    	return $success;
	}

	/**
	 * Retreive last game ID
	 *
	 * @var boolean
	 */
	public static function getLastGameId()
	{
		date_default_timezone_set('UTC');
		$game_id = DB::table('game')
			->orderBy('created_utc', 'desc')
			->pluck('id');

    	return $game_id;
	}

	/**
	 * Retreive last game
	 *
	 * @var boolean
	 */
	public static function getLastGame()
	{
		date_default_timezone_set('UTC');
		$game_id = DB::table('game')
			->select('game.id')
    		->orderBy('created_utc', 'desc')
    		->first();
    		//->take(1)
    		//->get();

    	return $game_id;
	}
}