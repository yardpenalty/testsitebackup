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
		body 		{ padding-top:30px; }
		form 		{ padding-bottom:20px; }
		.comment 	{ padding-bottom:20px; }
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
	<!--form ng-submit="submitUser()">

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

	<!-- User Table -->
	<!-- hide user table if the loading variable is true -->
	<table class="table" ng-hide="loading">
		<h3>Foosball User Rankings</h3>
		<thead>
			<tr>
				<th>Total Wins</th>
				<th>User ID</th>
				<th>User Name</th>
				<th>Email</th>
				<th>Score Total</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="user in users">
				<td>{{ user.ranking }}</td>
				<td>{{ user.user_id }}</td>
				<td>{{ user.user_name }}</td>
				<td>{{ user.email }}</td>
				<td>{{ user.score_total }}</td>
			</tr>
		</tbody>
			<!--p><a href="#" ng-click="deleteUser(user.id)" class="text-muted">Delete</a></p-->
	</table>
</div>

</body>
</html>