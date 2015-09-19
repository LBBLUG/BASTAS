'use strict';

angular.module('Bastas.Services')   
.service('recipientsService', ['$http', '$q', function($http, $q) {
  return({
        GetRecipients: GetRecipients,
        SaveRecipient: SaveRecipientDelegate
    });
  
  function GetRecipients()
  {
    var request = $q.defer();
    var response = {};
    response.data = [
      {
        id: 1,
        firstname: "Dan",
        lastname: "Ferguson",
        gender: "M",
        phone: "(806) 555-5555",
        address: "5502 42nd Street Apt. 983 Lubbock, TX 79409",
        gift1: "PS3",
        gift2: "Apple TV",
        gift3: "really soft blanket",
        route: "APS",
        complete: false
      },
      {
        id: 2,
        firstname: "Brian",
        lastname: "McG",
        gender: "M",
        phone: "(806) 444-444",
        address: "4426 Smithington Street Slaton, TX 97644",
        gift1: "iPhone 6s+",
        gift2: "iPad Pro",
        gift3: "pink slippers",
        route: "MOW",
        complete: true
      },
      {
        id: 3,
        firstname: "Terry",
        lastname: "Baugh",
        gender: "M",
        phone: "(806) 111-2222",
        address: "2210 Apple Bottom Blvd Lubbock, TX 79409",
        gift1: "Dell Inspiron 9000",
        gift2: "Farari",
        gift3: "really soft blanket",
        route: "APS",
        complete: false
      }
    ];
    request.resolve(response)
    return request.promise;
  }

  function SaveRecipientDelegate(recipient)
  {
    
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

