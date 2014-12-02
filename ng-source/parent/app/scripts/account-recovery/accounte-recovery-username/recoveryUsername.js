/**
 * Created by darko on 4/2/14.
 */
angular.module('accountRecoveryUsername',[])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider,ACCESS_LEVEL){
        $routeProvider.when('/username_recovery',{
            templateUrl:'views/signup/username_recovery.html',
            controllerUrl:ForgotUsernameCtrl,
            controllerAs:'forgotUsername',
            accessLevel:ACCESS_LEVEL.pub
        });
    }]);