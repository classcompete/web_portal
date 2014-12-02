'use strict'

angular.module('account',['resources.account'])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider, ACCESS_LEVEL){
        $routeProvider.when('/account',{
            templateUrl:'views/account.html',
            controller:AccountCtrl,
            controllerAs:'account',
            resolve:AccountCtrl.resolve,
            accessLevel:ACCESS_LEVEL.auth
        })
    }]);