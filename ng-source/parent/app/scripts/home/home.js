'use strict'

angular.module('home',['resources.statistic','resources.statistic.list'])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider,ACCESS_LEVEL){
        $routeProvider.when('/home',{
            templateUrl:'views/home.html',
            controller:HomeCtrl,
            controllerAs:'home',
            resolve: HomeCtrl.resolve,
            accessLevel: ACCESS_LEVEL.auth
        })
    }]);