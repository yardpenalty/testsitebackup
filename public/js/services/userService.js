angular.module('userService', [])

	.factory('User', function($http) {

		return {
			get : function() {
				return $http.get('api/user');
			},
			show : function(id) {
				return $http.get('api/user/' + id);
			},
			save : function(userData) {
				return $http({
					method: 'POST',
					url: 'api/user',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(userData)
				});
			},
			destroy : function(id) {
				return $http.delete('api/user/' + id);
			}
		}

	});