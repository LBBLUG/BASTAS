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

