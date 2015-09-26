'use strict';

angular.module('Bastas.Services')
    .service('giverService', ['$http', '$q', function($http, $q) {
      console.log("at the .service in giverService.");
        return ({
            addGiver: addGiver
        });

        function addGiver(lastName, firstName, address, email, homePhone, cellPhone, anonymous) {
            console.log("right before the http post request.");
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
            });
            console.log("right before the return.");
            return (request.then(handleSuccess, handleError));
        }
    }]);
