'use strict';

angular.module('Bastas.Controllers')

.controller('AboutController', ['$scope', function($scope) {

}])

.controller('BlogController', ['$scope', function($scope) {

}])

.controller('ContactController', ['$scope', function($scope) {

}])

.controller('HomeController', ['$scope', '$q', 'userService', 'imageService', function($scope, $q, userService, imageService) {
	$scope.MyProperty = 'Test String!';
	userService.GetUsers().then(function(data){
		$scope.Users = data;
	});
	$scope.Images = imageService.GetCarouselImages();
}])

.controller('AddUserController', ['$scope', 'userService', function($scope, userService) { 
    $scope.addUser = 'Add User - test to see this result!';
    $scope.getUsers = userService.addUsers();
}])

.controller('RecipientsController', ['$scope', 'recipientsService', function($scope, recipientsService) { 
    recipientsService.GetRecipients().then(function(success){
    	$scope.recipients = success.data;
    });
}])


.controller('RecipientController', ['$scope', '$routeParams', 'recipientsService', function($scope, $routeParams, recipientsService) { 
    $scope.Id = $routeParams.id;
}])

;
.controller('addGiverController', ['$scope', 'giverService', function($scope, giverService) { 
    $scope.addGiver = function() {
        giverService.addGiver($scope.lastName, $scope.firstName, $scope.address, $scope.email, $scope.homePhone, $scope.cellPhone, $scope.anonymous);
    };
    $scope.lastName = "";
    $scope.firstName="";
    $scope.address = {street: "", apt: "", city: "", state: "", zip: ""};
    $scope.email="";
    $scope.homePhone="";
    $scope.cellPhone="";
    $scope.anonymous="";
}])

/*.controller('addGiverController', ['$scope', 'giverService', function($scope, giverService) {
    $scope.addGiver = function() {
        giverService.addGiver($scope.formData);
    };
}])*/

;
