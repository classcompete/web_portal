'use strict'
angular.module('resources.support',['ngResource']);

var Support = function($resource, ENV){

    var support = $resource(ENV.url + '/support',{},{
        edit:{method:'PUT', url:ENV.url + '/support'}
    });


    return support;
};

Support.$inject = ['$resource','ENV'];
angular.module('resources.support').factory('SupportFactory', Support);