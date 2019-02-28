angular.module('addCtrl', [])

	.controller('addController', function($scope, $http, Score) {
		// object to hold all the data for the new score form
		$scope.scoreData = {};

		// loading variable to show the spinning loading icon
		$scope.loading = true;
		
		// get all the score first and bind it to the $scope.score object
		Score.get()
			.success(function(data) {
				$scope.scores = data;
				$scope.loading = false;
				console.log(data);
			});


		// function to handle submitting the form
		$scope.submitScore = function() {
			$scope.loading = true;

			// save the score. pass in score data from the form
			Score.save($scope.scoreData)
				.success(function(data) {

					// if successful, we'll need to refresh the score list
					Score.get()
						.success(function(getData) {
							$scope.scores = getData;
							$scope.loading = false;
							console.log(data);
							console.log("Game saved:" + data)
						});

				})
				.error(function(data) {
					console.log(data);
				});
		};

	});