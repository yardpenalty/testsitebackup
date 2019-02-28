<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

#################################################
################### HOME PAGE ###################
#################################################

Route::get('/', function()
{
	return View::make('index');
});

Route::get('/csv', function()
{
	return View::make('uploadCSV');
});

Route::get('/score', function()
{
	return View::make('addScore');
});

#################################################
################## API ROUTES ##################
#################################################
Route::group(array('prefix' => 'api'), function() {

	Route::resource('user', 'UserController', 
		array('only' => array('index', 'store', 'destroy')));
});

Route::post('api/upload', function()
{
    (array) $scores = Input::json();

    foreach ($scores as $data) {

		# Create Game
		Game::insertGame();
	    $game_id = Game::getLastGameId();
    		Log::debug("Game ID = ".$game_id);
		
		# Set User 1 data
		$user_1_name = Input::get('user_1_id');
		Log::debug("User 1 Name = " . $user_1_name);
		if (gettype($user_1_name) == 'string') {
			$user_1_id = User::getUserIdByUserName($user_1_name);
	    } else {
			$user_1_id = Input::get('user_1_id');
		}
	    	Log::debug("User 1 ID = ".$user_1_id);
	    $user_1_score = $data['user_1_score'];
	    	Log::debug("User 1 score = ".$user_1_score);
	    $user_1_winner = false;

		# Set User 2 data
		$user_2_name = Input::get('user_2_id');
		Log::debug("User 2 Name = " . $user_2_name);
		if (gettype($user_2_name) == 'string') {
			$user_2_id = User::getUserIdByUserName($user_2_name);
	    } else {
			$user_2_id = Input::get('user_2_id');
		}
	    	Log::debug("User 2 ID = ".$user_2_id);
	    $user_2_score = $data['user_2_score'];
	    	Log::debug("User 2 score = ".$user_2_score);
	    $user_2_winner = false;

	    if ($user_1_score > $user_2_score) {
	    	$user_1_winner = true;
	    	Log::debug("Winner is User 1.......");
	    } else {
	    	$user_2_winner = true;
	    	Log::debug("Winner is User 2.......");
	    }

	    $created_utc = time() * 1000;

	    # Insert Score for User 1
	    Score::insertScore($user_1_id,$game_id,$user_1_score,$user_1_winner);

	    # Insert Score for User 2
	    Score::insertScore($user_2_id,$game_id,$user_2_score,$user_2_winner);

    }

	# JSON Response
	return Response::json(array('status' => 'success'));

});

Route::get('api/score', function()
{    
    # JSON Response
	return Response::json(array(Score::getLastGame()));
});

Route::post('api/score', function()
{
	(array) $scores = Input::json();

	# Create Game
	Game::insertGame();
    $game_id = DB::getPdo()->lastInsertId();
    Log::debug("Game ID = ".$game_id);

	# Set User 1 data
	$user_1_name = Input::get('user_1_id');
	Log::debug("User 1 Name = " . $user_1_name);
	if (gettype($user_1_name) == 'string') {
		$user_1_id = User::getUserIdByUserName($user_1_name);
    } else {
		$user_1_id = Input::get('user_1_id');
	}
	
    Log::debug("User 1 ID = ".$user_1_id);
    $user_1_score = Input::get('user_1_score');
    Log::debug("User 1 score = ".$user_1_score);
    $user_1_winner = false;

	# Set User 2 data
	$user_2_name = Input::get('user_2_id');
	Log::debug("User 2 Name = " . $user_2_name);
	if (gettype($user_2_name) == 'string') {
		$user_2_id = User::getUserIdByUserName($user_2_name);
    } else {
		$user_2_id = Input::get('user_2_id');
	}
    Log::debug("User 2 ID = ".$user_2_id);
    $user_2_score = Input::get('user_2_score');
    Log::debug("User 2 score = ".$user_2_score);
    $user_2_winner = false;

    if ($user_1_score > $user_2_score) {
    	$user_1_winner = true;
    	Log::debug("Winner is User 1.......");
    } else {
    	$user_2_winner = true;
    	Log::debug("Winner is User 2.......");
    }

    $created_utc = time() * 1000;

    # Insert Score for User 1
    Score::insertScore($user_1_id,$game_id,$user_1_score,$user_1_winner);
    $score_id_1 = DB::getPdo()->lastInsertId();

    # Insert Score for User 2
    Score::insertScore($user_2_id,$game_id,$user_2_score,$user_2_winner);
    $score_id_2 = DB::getPdo()->lastInsertId();
    
    # JSON Response
    $return_array = array('game_id' => $game_id, 'score_id_1' => $score_id_1, 'score_id_2' => $score_id_2);
	return Response::json(array($return_array));
});

#################################################
################ CATCH ALL ROUTE ################
#################################################
// all routes that are not home or api will be redirected to the frontend
// this allows angular to route them
App::missing(function($exception)
{
	return View::make('index');
});