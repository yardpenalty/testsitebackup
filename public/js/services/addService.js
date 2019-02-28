angular.module('addService', [])

	.factory('Score', function($http) {

		return {
			get : function() {
				return $http.get('api/score');
			},
			save : function(scoreData) {
				return $http({
					method: 'POST',
					url: 'api/score',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(scoreData)
				});
			}
		}

	});