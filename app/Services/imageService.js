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
.service('imageService', ['$http', '$q', function($http, $q) {
  return({
        GetCarouselImages: GetCarouselImages
    });
  
  function GetCarouselImages()
  {
  	var images = [
    {
      id: 0,
      imagePath: "app/img/puppy.png",
      altText: "Picture of a puppy."
    },
    {
      id: 1,
      imagePath: "app/img/kitten.png",
      altText: "Picture of a kitten."
    },
    {
      id: 3,
      imagePath: "app/img/piggy.png",
      altText: "Picture of a piggy."
    }];
    return images;
  }
}]);

