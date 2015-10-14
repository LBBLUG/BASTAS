'use strict';

angular.module('Bastas.Services')
.service('addressService', ['$http', '$q', function($http, $q) {
  return({
        SaveAddress: SaveAddressDelegate
    });

  function SaveAddressDelegate(gift, recipientId)
  {
    
  }

}]);

