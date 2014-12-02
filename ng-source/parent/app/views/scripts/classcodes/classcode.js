angular.module('classcode',[])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider, ACCESS_LEVEL){
        $routeProvider.when('/classcode',{
            templateUrl:'views/classcode.html',
            controller:ClassCodeCtrl,
            controllerAs:'classCode',
            resolve:ClassCodeCtrl.resolve,
            accessLevel:ACCESS_LEVEL.auth
        })
    }]);