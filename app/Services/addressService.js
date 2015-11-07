'use strict';

angular.module('Bastas.Services')
.service('addressService', ['$http', '$q', function($http, $q) {
  return({
        SaveAddress: SaveAddressDelegate
    });

  function SaveAddressDelegate(address, recipientId)
  {
    var request = $http({
            method: "POST",
            url: "ssideScripts/saveAddress.php",
            data: {
                    Id: address.addressId,
                    streetAddress: address.street,
                    aptNumber: address.apt,
                    neighborhood: address.neighborhood,
                    city: address.city,
                    state: address.state,
                    zipCode: address.zip,
                    recipientId: recipientId
                  }
        }).then(function(response){
          //return response.data;
          return response.data.data[0];
        }, function(err){
          if (
          ! angular.isObject( response.data ) ||
          ! response.data.message
          ) {
            return( $q.reject( "An unknown error occurred." ) );
          }   
          // Otherwise, use expected error message.
          return( $q.reject( response.data.message ) );
        });
    return request;
  }

}]);

