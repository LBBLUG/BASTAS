/*

    BASTAS Web Management Application - Web Management of Be A Santa to A Senior and Similar generous programs
    Copyright (C) 2015  Lubbock Linux Users Group (Dan Ferguson, Christopher Cowden, Brian McGonagill)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see https://github.com/LBBLUG/BASTAS/blob/master/GNUV3.0PublicLicenseSoftware.txt.

*/

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
	/*userService.GetUsers().then(function(data){
		$scope.Users = data;
	});*/
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
            var modelIsValid = false;
            $scope.gifts.forEach(function(currentItem, index, array){
                if (!currentItem.isDeleted)
                {
                    modelIsValid = true;
                }
            });

            if(!modelIsValid)
            {
                alert("At least one gift is required per recipient. Please add a gift.");
                return;
            }

            // Save Person
            recipientsService.SaveRecipient($scope.personInfo).then(function(data){
                // Save Address
                addressService.SaveAddress($scope.address, data.Id);

                // Save Gifts
                $scope.gifts.forEach(function(currentItem, index, array){
                    if (currentItem.isDeleted)
                    {
                        giftService.DeleteGift(currentItem.giftId);
                    }
                    else
                    {
                        giftService.SaveGift(currentItem, data.Id);
                    }
                });

                $location.path("/recipients");
            })


        };

        $scope.AddRow = function(){
            var gift = {
                giftId: "",
                description: "",
                details: "",
                isDeleted: false,
                isPulled: false,
                isReceived: false,
                isDelivered: false,
                index: $scope.gifts.length
            };
            $scope.gifts.push(gift);
        };

        $scope.DeleteRow = function(id){
            $scope.gifts.forEach(function(currentValue, index, array){
                if (currentValue.index === id)
                {
                    if (currentValue.giftId === "" || currentValue.giftId === undefined)
                    {
                        array.splice(index, 1);
                        return;
                    }
                    currentValue.isDeleted = true;
                    return;
                };
            });
        };

        $scope.personInfo = {};
        $scope.address = {};
        $scope.gifts = [];
        if ($routeParams.id !== undefined && $routeParams.id !== "new") 
        {
            recipientsService.GetRecipient($routeParams.id).then(function(data){
                var personInfo = data[0];

                $scope.personInfo.personId = personInfo.main_id;
                $scope.personInfo.firstName = personInfo.firstname;
                $scope.personInfo.lastName = personInfo.lastname;
                $scope.personInfo.homePhone = personInfo.home_phone;
                $scope.personInfo.cellPhone = personInfo.cell_phone;
                $scope.personInfo.gender = personInfo.gender;
                $scope.personInfo.route = personInfo.route_no;

                $scope.address.addressId = personInfo.recip_address_id
                $scope.address.street = personInfo.street_address;
                $scope.address.apt = personInfo.apt_no;
                $scope.address.neighborhood = personInfo.neighborhood;
                $scope.address.city = personInfo.city;
                $scope.address.state = personInfo.state;
                $scope.address.zip = personInfo.zip_code;
            });
            
            giftService.GetGiftsByRecipientId($routeParams.id).then(function(data){
                var gifts = data;

                gifts.forEach(function(currentValue, index, array){
                    var gift = {};
                    gift.giftId = currentValue.gift_id;
                    gift.giftNo = currentValue.gift_no;
                    gift.description = currentValue.description;
                    gift.details = currentValue.size;
                    gift.giverId = currentValue.giver_id;
                    gift.isPulled = currentValue.gift_pulled === 0 ? false : true;
                    gift.isReceived = currentValue.gift_received === 0 ? false : true;
                    gift.isDelivered = currentValue.gift_delivered === 0 ? false : true;
                    gift.isDeleted = false;
                    gift.index = $scope.gifts.length;
                    $scope.gifts.push(gift);
                });
            })
        };
}])


.controller('AddGiverController', ['$scope', 'giverService', function($scope, giverService) { 
    $scope.addGiver = function() {
        giverService.addGiver($scope.lastName, $scope.firstName, $scope.address, $scope.email, $scope.homePhone, $scope.cellPhone, $scope.anonymous).then(function(GiverID){
            // pass returned giver id to the gifts / recipients selection view
            
        });
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
