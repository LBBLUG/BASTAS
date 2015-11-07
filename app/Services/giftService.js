'use strict';

angular.module('Bastas.Services')   
.service('giftService', ['$http', '$q', function($http, $q) {
  return({
        SaveGift: SaveGiftDelegate,
        DeleteGift: DeleteGiftDelegate
    });

  function SaveGiftDelegate(gift, recipientId)
  {
    var request = $http({
            method: "POST",
            url: "ssideScripts/saveGift.php",
            data: {
                    giftId: gift.giftId,
                    giftNo: gift.giftNo,
                    giftDescription: gift.description,
                    giftSize: gift.details,
                    mainId: recipientId,
                    giverId: gift.giverId
                  }
        }).then(function(response){
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

  function DeleteGiftDelegate(giftId)
  {
    var request = $http({
            method: "POST",
            url: "ssideScripts/deleteGift.php",
            data: {
                    giftId: giftId
                  }
        }).then(function(response){
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

