'use strict';

angular.module('Bastas.Services')   
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
    return( request.then( function(success){
      return success.data;
    }, function(err){
          if (
          ! angular.isObject( response.data ) ||
          ! response.data.message
          ) {
          return( $q.reject( "An unknown error occurred." ) );
      }
      // Otherwise, use expected error message.
      return( $q.reject( response.data.message ) );
        } ) );
  }
}]);

