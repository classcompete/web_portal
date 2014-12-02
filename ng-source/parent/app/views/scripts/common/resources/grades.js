'use strict'
angular.module('resources.grades',['ngResource']);

var Grades = function($resource, ENV){

    var grades = $resource(ENV.url + '/grade');


    return grades;
};

Grades.$inject = ['$resource','ENV'];
angular.module('resources.grades').factory('GradesFactory', Grades);