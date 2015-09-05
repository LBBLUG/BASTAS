'use strict';

angular.module('Bastas.Services')
.service('userService', [function() {
  this.GetUsers = function() { 
    return [{firstName: "Dan", lastName: "Ferguson"},
         {firstName: "Danielle", lastName: "Ferguson"},
         {firstName: "Paul", lastName: "Cowley"},
         {firstName: "Shontal", lastName: "Carruth"}];
       };
    
  
}])

.service('userService', [function() {
    this.addUsers = function() {
        
        return [{firstName: "Dan", lastName: "Ferguson"},
         {firstName: "Danielle", lastName: "Ferguson"},
         {firstName: "Paul", lastName: "Cowley"},
         {firstName: "Shontal", lastName: "Carruth"}];
       };
        
        
//        $.ajax("/ssideScripts/getUsers.php", {
//            beforeSend: function () {
//                console.log("About to get users.");
//            },
//            error: function() {
//              console.log("An error occurred while attempting to get users.");  
//            },
//            success: function(data) {
//                console.log("getUsers completed successfully.");
//                
//                //break out data array / return information to use.
//               
//            }
//        });

.service('userService', ['$http', '$q', function($http, $q) {
  return({
        GetUsers: GetUsers
    });
  
  function GetUsers()
  {
  	var request = $http({
        method: "get",
        url: "ssideScripts/getUsers.php"
    });
    return( request.then( handleSuccess, handleError ) );
  }

  // I transform the error response, unwrapping the application dta from
  // the API response payload.
  function handleError( response ) {
      // The API response from the server should be returned in a
      // nomralized format. However, if the request was not handled by the
      // server (or what not handles properly - ex. server error), then we
      // may have to normalize it on our end, as best we can.
      if (
          ! angular.isObject( response.data ) ||
          ! response.data.message
          ) {
          return( $q.reject( "An unknown error occurred." ) );
      }
      // Otherwise, use expected error message.
      return( $q.reject( response.data.message ) );
  }

  // I transform the successful response, unwrapping the application data
  // from the API response payload.
  function handleSuccess( response ) {
      return( response.data.data );
  }
}]);

