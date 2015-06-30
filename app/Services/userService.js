'use strict';

angular.module('Bastas.Services')

.service('userService', [function() {
  this.GetUsers = function() { 
    return [{firstName: "Dan", lastName: "Ferguson"},
         {firstName: "Danielle", lastName: "Ferguson"},
         {firstName: "Paul", lastName: "Cowley"},
         {firstName: "Shontal", lastName: "Carruth"}];
       };
  
}]);

