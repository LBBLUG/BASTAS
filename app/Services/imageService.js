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

