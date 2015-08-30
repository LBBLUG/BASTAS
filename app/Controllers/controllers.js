'use strict';

angular.module('Bastas.Controllers')

.controller('AboutController', ['$scope', function($scope) {

}])

.controller('BlogController', ['$scope', function($scope) {

}])

.controller('ContactController', ['$scope', function($scope) {

}])

.controller('HomeController', ['$scope', 'userService', function($scope, userService) {
	$scope.MyProperty = 'Test String!';
  $scope.Users = userService.GetUsers();
}])

.controller('addUserController', ['$scope', 'userService', function($scope, userService) { 
    $scope.addUser = 'Add User - test to see this result!';
    $scope.getUsers = userService.addUsers();
}]);
