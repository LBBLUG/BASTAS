'use strict';

angular.module('Bastas.Services')   
.service('recipientsService', ['$http', '$q', function($http, $q) {
  return({
        GetRecipients: GetRecipientsDelegate,
        GetRecipient: GetRecipientDelegate,
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


  function GetRecipientDelegate(recordId)
  {
    var request = $http({
            method: "GET",
            url: "ssideScripts/getRecipient.php?id=" + recordId
        }).then(function(response){
          //return response.data;
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
    var request = $http({
            method: "POST",
            url: "ssideScripts/saveRecipient.php",
            data: {
                    id: recipient.personId,
                    lastName: recipient.lastName,
                    firstName: recipient.firstName,
                    gender: recipient.gender,
                    route: recipient.routeNo,
                    homePhone: recipient.homePhone,
                    cellPhone: recipient.cellPhone
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

  // // I transform the error response, unwrapping the application dta from
  // // the API response payload.
  // function handleError( response ) {
  //     // The API response from the server should be returned in a
  //     // nomralized format. However, if the request was not handled by the
  //     // server (or what not handles properly - ex. server error), then we
  //     // may have to normalize it on our end, as best we can.
  //     if (
  //         ! angular.isObject( response.data ) ||
  //         ! response.data.message
  //         ) {
  //         return( $q.reject( "An unknown error occurred." ) );
  //     }
  //     // Otherwise, use expected error message.
  //     return( $q.reject( response.data.message ) );
  // }

  // // I transform the successful response, unwrapping the application data
  // // from the API response payload.
  // function handleSuccess( response ) {
  //     return( response.data );
  // }
}]);

