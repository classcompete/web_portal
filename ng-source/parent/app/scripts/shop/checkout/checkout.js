angular.module('checkout',['resources.checkout'])
    .config(['$routeProvider','ACCESS_LEVEL', function($routeProvider, ACCESS_LEVEL){
        $routeProvider.when('/checkout',{
            templateUrl:'views/shop/checkout.html',
            controller:CheckoutCtrl,
            controllerAs:'c_checkout',
            accessLevel:ACCESS_LEVEL.auth,
            resolve:CheckoutCtrl.resolve
        })
    }]);