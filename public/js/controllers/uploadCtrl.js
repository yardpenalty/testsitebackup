angular.module('uploadCtrl', [])

	.controller('uploadController', function($scope, $http, User) {
		// object to hold all the data for the new user form
		$scope.userData = {};

		// loading variable to show the spinning loading icon
		$scope.loading = true;
		
		// get all the users first and bind it to the $scope.users object
		User.get()
			.success(function(data) {
				$scope.users = data;
				$scope.loading = false;
				console.log(data);
			});


		// function to handle submitting the form
		$scope.uploadCSV = function() {
			$scope.loading = true;

			// save the user. pass in user data from the form
			User.save($scope.userData)
				.success(function(data) {

					// if successful, we'll need to refresh the user list
					User.get()
						.success(function(getData) {
							$scope.users = getData;
							$scope.loading = false;
							console.log(data);
							console.log("User created:" + data)
						});

				})
				.error(function(data) {
					console.log(data);
				});
		};

		// function to handle deleting a user
		$scope.deleteUser = function(id) {
			$scope.loading = true; 

			User.destroy(id)
				.success(function(data) {

					// if successful, we'll need to refresh the user list
					User.get()
						.success(function(getData) {
							$scope.users = getData;
							$scope.loading = false;
							console.log(data);
						});

				});
		};

	});