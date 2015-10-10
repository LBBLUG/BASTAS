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

.controller('RecipientsController', ['$scope', 'recipientsService', '$filter', function($scope, recipientsService, $filter) { 
    $scope.RunFilter = function(){
        // Function that is run after each filter field edit. 
        $scope.filteredRecipients = $scope.recipients;
        $scope.filteredRecipients = $filter('stringContainsByProperty')($scope.filteredRecipients, "size", $scope.filterSize);
        $scope.filteredRecipients = $filter('stringContainsByProperty')($scope.filteredRecipients, "main_id", $scope.filterId);
        $scope.filteredRecipients = $filter('stringContainsByProperty')($scope.filteredRecipients, "route_no", $scope.filterRoute);
        $scope.filteredRecipients = $filter('stringContainsByProperty')($scope.filteredRecipients, "firstname", $scope.filterFirstName);
        $scope.filteredRecipients = $filter('stringContainsByProperty')($scope.filteredRecipients, "lastname", $scope.filterLastName);
        $scope.filteredRecipients = $filter('stringContainsByProperty')($scope.filteredRecipients, "gender", $scope.filterGender);
        $scope.filteredRecipients = $filter('stringContainsByProperty')($scope.filteredRecipients, "description", $scope.filterGift);
        $scope.filteredRecipients = $filter('stringContainsByProperty')($scope.filteredRecipients, "home_phone", $scope.filterPhone);
        $scope.filteredRecipients = $filter('booleanByProperty')($scope.filteredRecipients, "complete", $scope.filterComplete);
        $scope.filteredRecipients = $filter('booleanByProperty')($scope.filteredRecipients, "gift_received", $scope.filterGiftReceived);
        $scope.GiftCount = $scope.filteredRecipients.length;

        // We do all of this just so we can get a count of people. We are esentially doing a group by on main_id.
        var tempArg = [];
        var arrayIndex = 0;
        $scope.filteredRecipients.forEach(function(currentValue, index, array){
            if(tempArg[String(currentValue.main_id) + "_"] !== undefined)
            {
                tempArg[tempArg[String(currentValue.main_id) + "_"]]++;
                return;
            }
            tempArg[String(currentValue.main_id) + "_"] = arrayIndex;
            tempArg[arrayIndex] = 1;
            arrayIndex++;
        });
        if (tempArg)
        {
            $scope.PeopleCount = tempArg.length;
        }
        else
        {
            $scope.PeopleCount = 0;
        }


    };
    recipientsService.GetRecipients().then(function(success){
    	$scope.recipients = success.data;
        $scope.RunFilter();
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
        }, function(err){
            alert("Error in RecipientController: " + err);
        });
    });
}])


.controller('RecipientController', ['$scope', '$routeParams', 'recipientsService', function($scope, $routeParams, recipientsService) { 
    recipientsService.GetRecipient($routeParams.id).then(function(success){
        $scope.recipient_id = success.data;
    });
}])


.controller('AddGiverController', ['$scope', 'giverService', function($scope, giverService) { 
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



;
