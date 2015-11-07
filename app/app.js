'use strict';

// Declare app level module which depends on views, and components
var app = angular.module('Bastas.App', [
  'Bastas.Directives',
  'Bastas.Controllers',
  'Bastas.Services',
  'Bastas.Filters',
  'ngRoute',
]);
angular.module('Bastas.Directives', ['Bastas.Filters']);
angular.module('Bastas.Controllers', ['Bastas.Filters', 'ui.bootstrap', 'ngAnimate']);
angular.module('Bastas.Services', []);
angular.module('Bastas.Filters', []);

// This tells AngularJS to show the Home.html partial view when the browser
app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
  $routeProvider
  .when('/', {
    templateUrl: 'app/Views/Home.html',
    controller: 'HomeController',
    caseInsensitiveMatch: true
  })
  .when('/Recipients', {
    templateUrl: 'app/Views/Recipients.html',
    controller: 'RecipientsController',
    caseInsensitiveMatch: true
  })
  .when('/Recipients/:id', {
    templateUrl: 'app/Views/Recipient.html',
    controller: 'RecipientController',
    caseInsensitiveMatch: true
  })
  .when('/Recipients/new', {
    templateUrl: 'app/Views/Recipient.html',
    controller: 'RecipientController',
    caseInsensitiveMatch: true
  })
  .when('/gift-giver', {
     // This section sends the user to the Add User window
     templateUrl: 'app/Views/AddGiver.html',
     controller: 'AddGiverController',
    caseInsensitiveMatch: true
  })

  .otherwise({
    // This tells AngularJS to show the Home.html when the path is an unknown match
    redirectTo: '/'});


  // We can enable this if we ever get a PHP route engine integrated into the 
  // server. This will beautify our URLs, but without the router it breaks the page
  //
  //$locationProvider.html5Mode(true);

}])

// .config(['$routeProvider', '$locationProvider'], function($routeProvider, $locationProvider) {
// 	$locationProvider.html5Mode(true);
// 	$locationProvider.hashPrefix('!');
// });
