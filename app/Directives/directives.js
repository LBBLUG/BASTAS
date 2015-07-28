'use strict';

// Declare app level module which depends on views, and components
var app = angular.module('Bastas.Directives');

app.directive('bodyBlock', [function() {
  return {
    restrict: 'AE',
    replace: 'true',
    templateUrl: 'js/app/Directives/bodyBlock.html'

  };
}])
