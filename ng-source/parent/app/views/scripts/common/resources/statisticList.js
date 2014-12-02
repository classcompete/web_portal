angular.module('resources.statistic.list',['ngResource']);

var StatisticList = function($resource, ENV){

    var stat = $resource(ENV.url + '/statistic/:id',{id:"@id"},{
        get:{method:"GET",cache : true}
    });


    return stat;
};

StatisticList.$inject = ['$resource','ENV'];
angular.module('resources.statistic.list').factory('StatisticListFactory', StatisticList);