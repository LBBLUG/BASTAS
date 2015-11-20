'use strict';

angular.module('Bastas.Services')   
.service('giftService', ['$http', '$q', function($http, $q) {
  return({
        GetGiftsByRecipientId: GetGiftsByRecipientIdDelegate,
        SaveGift: SaveGiftDelegate,
        DeleteGift: DeleteGiftDelegate
    });

  function GetGiftsByRecipientIdDelegate(recipientId)
  {
    var request = $http({
            method: "GET",
            url: "ssideScripts/getGifts.php?recipientId=" + recipientId
        }).then(function(response){
          return response.data.data;
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
                    giverId: gift.giverId,
                    isPulled: !gift.isPulled || gift.isPulled === undefined ? false : true,
                    isReceived: !gift.isReceived || gift.isReceived === undefined ? false : true,
                    isDelivered: !gift.isDelivered || gift.isDelivered === undefined ? false : true
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

