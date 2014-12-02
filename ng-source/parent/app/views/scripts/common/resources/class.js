'use strict'
angular.module('resources.classes',['ngResource']);

var Classes = function($resource, ENV){

    var classes = $resource(ENV.url + '/classes');


    return classes;
};

Classes.$inject = ['$resource','ENV'];
angular.module('resources.classes').factory('ClassesFactory', Classes);