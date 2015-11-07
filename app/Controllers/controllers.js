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


.controller('RecipientController', ['$scope', 
    '$routeParams', 
    'recipientsService', 
    'giftService',
    'addressService',
    '$location',
    function($scope, $routeParams, recipientsService, giftService, addressService, $location) { 

        $scope.Cancel = function()
        {
            $location.path("/recipients");
        };

        $scope.Save = function(){
            // Save Person
            recipientsService.SaveRecipient($scope.personInfo).then(function(data){
                // Save Address
                addressService.SaveAddress($scope.address, data.Id);

                // Save Gifts
                $scope.gifts.forEach(function(currentItem, index, array){
                    giftService.SaveGift(currentItem, data.Id);
                });

                $location.path("/recipients");
            })


        };

        $scope.AddRow = function(){
            var temp = $scope.gifts.length;
            var gift = {
                giftId: "",
                description: "",
                details: "",
                DeleteRow: function(){
                    deleteRow(temp);
                }
            };
            $scope.gifts.push(gift);
        };

        var deleteRow = function(index){
            $scope.gifts.splice(index, 1);
            $scope.gifts.forEach(function(currentItem, index, array){
                currentItem.DeleteRow = function(){
                    deleteRow(index);
                };
            });
        };

        if ($routeParams.id !== undefined) 
        {
            recipientsService.GetRecipient($routeParams.id).then(function(success){
                var gifts = success.data;
                var personInfo = gifts[0];

                $scope.personInfo = {};
                $scope.personInfo.personId = personInfo.main_id;
                $scope.personInfo.firstName = personInfo.firstname;
                $scope.personInfo.lastName = personInfo.lastname;
                $scope.personInfo.homePhone = personInfo.home_phone;
                $scope.personInfo.cellPhone = personInfo.cell_phone;
                $scope.personInfo.gender = personInfo.gender;
                $scope.personInfo.routeNo = personInfo.route_no;

                $scope.address = {};
                $scope.address.addressId = personInfo.recip_address_id
                $scope.address.street = personInfo.street_address;
                $scope.address.apt = personInfo.apt_no;
                $scope.address.neighborhood = personInfo.neighborhood;
                $scope.address.city = personInfo.city;
                $scope.address.state = personInfo.state;
                $scope.address.zip = personInfo.zip_code;

                $scope.gifts = [];
                gifts.forEach(function(currentValue, index, array){
                    var gift = {};
                    gift.giftId = currentValue.gift_id;
                    gift.giftNo = currentValue.gift_no;
                    gift.description = currentValue.description;
                    gift.details = currentValue.size;
                    gift.giverId = currentValue.giver_id
                    gift.DeleteRow = function(){
                        deleteRow(index);
                    };
                    $scope.gifts.push(gift);
                });

            });
        };


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
