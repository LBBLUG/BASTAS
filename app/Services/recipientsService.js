'use strict';

angular.module('Bastas.Services')   
.service('recipientsService', ['$http', '$q', function($http, $q) {
  return({
        GetRecipients: GetRecipientsDelegate,
        SaveRecipient: SaveRecipientDelegate
    });
  
  function GetRecipientsDelegate()
  {
    var request = $http({
            method: "GET",
            url: "ssideScripts/getRecipients.php"
        }).then(function(response){
          return response.data;
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

  function SaveRecipientDelegate(recipient)
  {
    
  }
}]);

