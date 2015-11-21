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


  function GetRecipientDelegate(recordId)
  {
    var request = $http({
            method: "GET",
            url: "ssideScripts/getRecipient.php?id=" + recordId
        }).then(function(response){
          //return response.data;
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
                    route: recipient.route,
                    homePhone: recipient.homePhone,
                    cellPhone: recipient.cellPhone
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

