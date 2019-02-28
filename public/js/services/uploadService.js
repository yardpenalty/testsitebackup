angular.module('uploadService', [])

	.factory('Upload', function($http) {

		return {
			save : function(uploadData) {
				return $http({
					method: 'POST',
					url: 'api/upload',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(uploadData)
				});
			}
		}

	});