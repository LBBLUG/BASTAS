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
//                $("#Results").append($("<div>Admin User created successfully. <br /></div>"));
//               
//            }
//        });

}]);

