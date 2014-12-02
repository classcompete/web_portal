'use strict'

angular.module('support',['resources.support'])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider, ACCESS_LEVEL){
        $routeProvider.when('/support',{
            templateUrl:'views/support.html',
            controller:SupportCtrl,
            controllerAs:'c_support',
            resolve:SupportCtrl.resolve,
            accessLevel:ACCESS_LEVEL.auth
        })
    }]);