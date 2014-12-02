'use strict'
angular.module('accountRecoveryPassword',[])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider, ACCESS_LEVEL){
            $routeProvider.when('/password_recovery',{
                templateUrl:'views/signup/password_recovery.html',
                controller:ForgotPasswordCtrl,
                controllerAs:'forgotPwd',
                accessLevel:ACCESS_LEVEL.pub
            })
    }]);