'use strict';

// Declare app level module which depends on views, and components
var app = angular.module('Bastas.Directives');

app.directive('userRow', [function() {
  return {
    restrict: 'AE',
    replace: 'true',
    scope: {
        datasource: '='
    },
    templateUrl: 'app/Directives/userRow.html'
  };
}])
