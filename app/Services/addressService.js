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
          return response.data.data[0];
        }, function(err){
          if (
          ! angular.isObject( err.data ) ||
          ! err.data.message
          ) {
            return( $q.reject( "An unknown error occurred." ) );
          }   
          // Otherwise, use expected error message.
          return( $q.reject( err.data.message ) );
        });
    return request;
  }

}]);

