'use strict';

angular.module('Bastas.Filters')   
.filter('stringContainsByProperty', [function() {
  return function(input, propertyName, searchString)
    {
      if (!searchString || searchString === "")
      {
        return input;
      }
      var output = [];
      input.forEach(function(value, index, arr){
        if (!value[propertyName] || String(value[propertyName]).toLowerCase().indexOf(searchString.toLowerCase()) > -1)
        {
          output.push(value);
        }
      }); 
      return output;
    };
}])
  
.filter('stringContainsByPropertyList', [function() {
  return function(input, propertyNameList, searchString)
    {
      if (!searchString || searchString === "")
      {
        return input;
      }
      var output = [];
      var propertyList = propertyNameList.split(',')
      input.forEach(function(inputValue, inputIndex, inputArr){
        propertyList.forEach(function(propValue, propIndex, propArr){
          if (!inputValue[propValue] || String(inputValue[propValue]).toLowerCase().indexOf(searchString.toLowerCase()) > -1)
          {
            output.push(inputValue);
          }
        });
      }); 
      return output;
    };
}])
 
.filter('stringEqualsByPropertyList', [function() {
  return function(input, propertyName, searchString)
    {
      if (!searchString || searchString === "")
      {
        return input;
      }
      var output = [];
      input.forEach(function(value, index, arr){
        if (!value[propertyName] || value[propertyName].toLowerCase().trim() === searchString.toLowerCase().trim())
        {
          output.push(value);
        }
      }); 
      return output;
    };
}])

.filter('booleanByProperty', [function() {
  return function(input, propertyName, boolValue)
    {
      if (typeof(boolValue) !== "boolean" && boolValue !== "true" && boolValue !== "false")
      {
        return input;
      }
      if (boolValue === "true")
      {
        boolValue = true;
      }
      else if (boolValue === "false")
      {
        boolValue = false;
      }
      var output = [];
      input.forEach(function(inputValue, inputIndex, inputArr){
        if (typeof(inputValue[propertyName]) !== "boolean" || inputValue[propertyName] === boolValue)
        {
          output.push(inputValue);
        }
      }); 
      return output;
    };
}])

.filter('toYesNo', [function() {
  return function(input)
    {
      if (typeof(input) !== "boolean")
      {
        return input;
      }
      if (input)
      {
        return "Yes";
      }
      return "No";
    };
}])

;

