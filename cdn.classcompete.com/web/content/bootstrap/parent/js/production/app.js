google.load('visualization', '1', {
    packages: ['corechart', 'geochart']
});
var app = angular.module('parent-app',['ngRoute','ui.bootstrap','ivpusic.cookie','parent-app.directives','parent-app.services','parent-app.filters','plupload.module','ezfb'])
    .config(['$routeProvider','$FBProvider', function($routeProvider,$FBProvider){
        $routeProvider.when('/login',{templateUrl:'partials/login.html', controller:'LoginCtrl'});
        $routeProvider.when('/registration',{templateUrl:'partials/registration.html', controller:'RegistrationCtrl'});
        $routeProvider.when('/login_error', {templateUrl:'partials/login_error.html', controller:'LoginErrorCtrl'});
        $routeProvider.when('/forgot_password',{templateUrl:'partials/forgot_password.html', controller:'ForgotPasswordCtrl'});
        $routeProvider.when('/children', {templateUrl:'partials/children.html', controller:'ChildrenCtrl'});
        $routeProvider.when('/profile',{templateUrl:'partials/profile.html', controller:'ProfileCtrl'});
        $routeProvider.when('/social_network_connections',{templateUrl:'partials/social_network_connections.html',controller:'SocialNetworkConCtrl'});
        $routeProvider.when('/manage_children', {templateUrl:'partials/manage_children.html', controller:'ManageChildrenCtrl'});
        $routeProvider.when('/demo', {templateUrl:'partials/demo.html', controller:'DemoCtrl'});
        $routeProvider.when('/', {redirectTo:'/children'});
        $routeProvider.otherwise('/login');

        $FBProvider.setInitParams({
            appId:'225058110951151'
        });
}]);
app.constant('ParentAppSettings',{
    googleId:'886463280515-u6d66bo6pvfo6of9s8cvjbq7s4tj1p2m.apps.googleusercontent.com'
});
app.run(['$rootScope','$location','$http','ipCookie','LoginResource',function($rootScope, $location, $http, ipCookie, LoginResource){

    $rootScope.images_url   = "http://images.classcompete.com/";
    $rootScope.parent_image_upload = "http://images.classcompete.com/parent_image";
    $http.defaults.headers.common['X-API-KEY'] = ipCookie('parent-classcompete');

    $rootScope.$on( "$routeChangeStart", function(event, next, current) {

        if(next.originalPath !== '/login_error' && next.originalPath !== '/login' && next.originalPath !== '/registration' && next.originalPath !== '/forgot_password'){
            LoginResource.is_logged().$promise.then(function(data){
                $rootScope.user          = data;
                $rootScope.parent_image = data.parent_image;
            });
        }
    });
}]);