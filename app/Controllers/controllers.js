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
        $scope.recipients.forEach(function(value, index, arr){
            // Create a new property on each object in the collection called "complete"
            // The property compares the count of gifts that have a giver_id that is not null to the max gift_no
            // If the former is greater than or equal to the latter then all the gifts for this receipient are collected.
            // NOTE 1: This may not be the best way to do this. If we get lots of records this could take a while to run and slow down the web page
            // 
            value.complete = arr.filter(function(x){
                return $.isNumeric(x.giver_id) && x.main_id === value.main_id;
            }).length >= arr.filter(function(x){
                return x.main_id === value.main_id;
            }).length;

            // This creates a new property that indicates if the gift has been recieved.
            value.gift_received = $.isNumeric(value.giver_id);
        });
    });
}])

.controller('RecipientController', ['$scope', '$routeParams', 'recipientsService', function($scope, $routeParams, recipientsService) { 
    recipientsService.GetRecipient($routeParams.id).then(function(success){
        $scope.recipients = success.data;
    });
}])

;
