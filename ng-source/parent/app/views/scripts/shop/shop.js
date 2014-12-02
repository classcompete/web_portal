'use strict';

angular.module('shop',['resources.classes','checkout','resources.class_connection'])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider, ACCESS_LEVEL){
        $routeProvider.when('/shop',{
            templateUrl:'views/shop/shop.html',
            controller:ShopCtrl,
            controllerAs:'c_shop',
            resolve:ShopCtrl.resolve,
            accessLevel:ACCESS_LEVEL.auth
        })
    }]);