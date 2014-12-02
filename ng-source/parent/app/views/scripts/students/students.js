'use strict'
angular.module('students',['resources.students','resources.grades','resources.parent-students'])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider, ACCESS_LEVEL){
        $routeProvider.when('/students',{
            templateUrl:'views/student.html',
            controller:StudentCtrl,
            controllerAs:'c_student',
            resolve:StudentCtrl.resolve,
            accessLevel:ACCESS_LEVEL.auth
        })
    }]);