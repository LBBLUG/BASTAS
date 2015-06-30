'use strict';

// Declare app level module which depends on views, and components
var app = angular.module('Bastas.App', [
  'Bastas.Directives',
  'Bastas.Controllers',
  'Bastas.Services',
  'ngRoute',
]);
angular.module('Bastas.Directives', []);
angular.module('Bastas.Controllers', []);
angular.module('Bastas.Services', []);

// This tells AngularJS to show the Home.html partial view when the browser
app.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/Home', {
    templateUrl: 'app/Views/Home.html',
    controller: 'HomeController'
  });

// This tells AngularJS to show the Home.html when the path is an unknown match
  $routeProvider.otherwise({redirectTo: '/Home'});
}])

// .config(['$routeProvider', '$locationProvider'], function($routeProvider, $locationProvider) {
// 	$locationProvider.html5Mode(true);
// 	$locationProvider.hashPrefix('!');
// });
