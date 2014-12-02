'use strict'
angular.module('resources.country',['ngResource']);

var Country = function($resource, ENV){

    var country = $resource(ENV.url + '/country');


    return country;
};

Country.$inject = ['$resource','ENV'];
angular.module('resources.country').factory('CountryFactory', Country);