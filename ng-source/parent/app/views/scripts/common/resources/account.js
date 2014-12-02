'use strict'
angular.module('resources.account',['ngResource']);

var Account = function($resource, ENV){

    var account = $resource(ENV.url + '/account',{},{
        edit:{method:'PUT', url:ENV.url + '/account'},
        update_intro:{method:'PUT', url:ENV.url + '/account/intro'}
    });


    return account;
};

Account.$inject = ['$resource','ENV'];
angular.module('resources.account').factory('AccountFactory', Account);