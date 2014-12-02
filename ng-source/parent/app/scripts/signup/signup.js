'use strict';
angular.module('signup',['signup-login','signup-registration','validation','steps','signup.social'])
    .config(['$routeProvider', function($routeProvider){
        $routeProvider.when('/signup',{
            templateUrl:'views/signup/signup.html'
            });
    }]);