'use strict'
angular.module('setupstudent',['resources.grades','resources.students'])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider, ACCESS_LEVEL){
        $routeProvider.when('/setup_student',{
            templateUrl:'views/setupstudent.html',
            controller:SetupStudentCtrl,
            controllerAs:'setupStudent',
            accessLevel: ACCESS_LEVEL.pub.registered,
            resolve: SetupStudentCtrl.resolve
        })
    }]);