'use strict';

angular.module('Bastas.Controllers')

.controller('AboutController', ['$scope', function($scope) {

}])

.controller('BlogController', ['$scope', function($scope) {

}])

.controller('ContactController', ['$scope', function($scope) {

}])

.controller('HomeController', ['$scope', '$q', 'userService', function($scope, $q, userService) {
	$scope.MyProperty = 'Test String!';
	userService.GetUsers().then(function(data){
		$scope.Users = data;
	});
}])

.controller('AddUserController', ['$scope', 'userService', function($scope, userService) {
    $scope.UserProperty = 'Add User';
    $scope.Users = userService.AddUsers();
}]);
