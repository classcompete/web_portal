'use strict'
angular.module('intro',['resources.account'])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider, ACCESS_LEVEL){
        $routeProvider.when('/intro',{
            templateUrl:'views/intro.html',
            controller:IntroCtrl,
            controllerAs:'intro',
            accessLevel: ACCESS_LEVEL.registered
        });
    }]);