angular.module('resources.statistic',['ngResource']);

var Statistic = function($resource, ENV){

    var students = $resource(ENV.url + '/statistic',{},{});


    return students;
};

Statistic.$inject = ['$resource','ENV'];
angular.module('resources.students').factory('StatisticFactory', Statistic);