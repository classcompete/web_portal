'use strict'
angular.module('resources.class_connection',['ngResource']);

var ClassConnection = function($resource, ENV){

    var classConnection = $resource(ENV.url + '/class_student');


    return classConnection;
};

ClassConnection.$inject = ['$resource','ENV'];
angular.module('resources.class_connection').factory('ClassConnectionFactory', ClassConnection);
