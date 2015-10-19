'use strict';

angular.module('Bastas.Services')   
.service('giftService', ['$http', '$q', function($http, $q) {
  return({
        SaveGift: SaveGiftDelegate
    });

  function SaveGiftDelegate(gift, recipientId)
  {
    $http({
            method: "POST",
            url: "ssideScripts/getRecipient.php?id=" + recordId,
            )
    
  }

}]);

