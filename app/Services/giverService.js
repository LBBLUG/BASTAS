'use strict';



angular.module('Bastas.Services')
    .service('giverService', ['$http', '$q', function ($http, $q) {
        return ({
            addGiver: addGiver
        });

        function addGiver(lastName, firstName, address, email, homePhone, cellPhone, anonymous) {
            var request = $http({
                method: "post",
                url: "ssideScripts/addGiver.php",
                data: { lastName: lastName,
                       firstName: firstName,
                       address: address,
                       email: email,
                       homePhone: homePhone,
                       cellPhone: cellPhone,
                       anonymous: anonymous
                      }
            }).then(function(response){
            	return response.data;
            	},function (err) {
            		return ($q.reject ('An Error occurred in giverService.'));
            	});
        }
    }]);
