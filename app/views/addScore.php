  <!-- app/views/index.php -->
<!doctype html>
<html lang="en" ng-app="zipongoApp">
<head>
  <meta charset="UTF-8">
  <title>Foosball Rankings</title>

  <!-- CSS -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css"> <!-- load bootstrap via cdn -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"> <!-- load fontawesome -->
  <style>
    body    { padding-top:30px; }
    form    { padding-bottom:20px; }
    .comment  { padding-bottom:20px; }
    .nav.navbar-nav.navbar-right { margin-right: 50px; }
    table, th, td { border: 1px solid black; }
    th { background-color: #000000; color: orange; } 
  </style>

  <!-- JS -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->
  <!--script src="jquery.min.js"></script>
  <script src="jquery.dataTables.min.js"></script>
  <script src="angular.min.js"></script>
  <script src="angular-datatables.min.js"></script-->

  <!-- ANGULAR -->
  <!-- all angular resources will be loaded from the /public folder -->
    <script src="js/app.js"></script> <!-- load our application -->
    <script src="js/controllers/mainCtrl.js"></script> <!-- load our controller -->
    <script src="js/services/userService.js"></script> <!-- load our service -->
    <script src="js/services/uploadService.js"></script> <!-- load our service -->
    <script src="js/services/addService.js"></script> <!-- load our service -->

</head>
<!-- declare our angular app and controller -->
<body class="container" ng-app="zipongoApp" ng-controller="mainController">

<!-- HEADER AND NAVBAR -->
<header>
    <nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Foosball Rankings</a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="/"><i class="fa fa-home"></i> Rankings</a></li>
            <li><a href="/csv"><i class="fa fa-shield"></i> Upload</a></li>
            <li><a href="/score"><i class="fa fa-comment"></i> Add</a></li>
        </ul>
    </div>
    </nav>
</header>

<div class="col-md-8 col-md-offset-2">

  <!-- Enter New Game with Scores =============================================== -->
  <form ng-submit="submitScore()" class="form-horizontal" role="form">
    <h4 class="well well-sm" style="margin-bottom:25px;">Enter Foosball Game Details to Update Rankings:</h4>
    <div class="row" style="margin-bottom:45px;">
      <label for="player1Name" class="col-sm-2 control-label">Player 1 Name</label>
      <div class="col-xs-4">
        <input name="user_1_id" ng-model="scoreData.user_1_id" id="player1Name" type="text" class="form-control" placeholder="User Name for Player 1">
      </div>
      <label for="player1Score" class="col-sm-2 control-label">Player 1 Score</label>
      <div class="col-xs-3">
        <input name="user_1_score" ng-model="scoreData.user_1_score" id="player1Score" type="text" class="form-control" placeholder="Score for Player 1">
      </div>
    </div>
    <div class="row" style="margin-bottom:45px;">
      <label for="player2Name" class="col-sm-2 control-label">Player 2 Name</label>
      <div class="col-xs-4">
        <input name="user_2_id" ng-model="scoreData.user_2_id" id="player2Name" type="text" class="form-control" placeholder="User Name for Player 2">
      </div>
      <label for="player2Score" class="col-sm-2 control-label">Player 2 Score</label>
      <div class="col-xs-3">
        <input name="user_2_score" ng-model="scoreData.user_2_score" id="player2Score" type="text" class="form-control" placeholder="Score for Player 2">
      </div>
    </div>
    <div class="form-group text-right">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary btn-sm">Submit Game</button>
      </div>
    </div>
  </form>
  <!--form ng-submit="submitUser()"> class="btn btn-default"

    <div class="form-group">
      <input type="text" class="form-control input-sm" name="user_name" ng-model="userData.user_name" placeholder="Name">
    </div>

    <div class="form-group">
      <input type="text" class="form-control input-lg" name="email" ng-model="userData.email" placeholder="Email">
    </div>

    <div class="form-group">
      <input type="text" class="form-control input-lg" name="password" ng-model="userData.password" placeholder="Password">
    </div>

    <div class="form-group">
      <input type="hidden" class="form-control input-lg" name="created_utc" ng-model="userData.created_utc" value="1414636902000">
    </div>
    
    <div class="form-group text-right"> 
      <button type="submit" class="btn btn-primary btn-lg">Submit</button>
    </div>
  </form-->

  <!-- LOADING ICON -->
  <!-- show loading icon if the loading variable is set to true -->
  <p class="text-center" ng-show="loading"><span class="fa fa-meh-o fa-5x fa-spin"></span></p>

</div>

</body>
</html>