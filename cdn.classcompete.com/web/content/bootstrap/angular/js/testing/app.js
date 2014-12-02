'user strict'
google.load('visualization', '1', {
    packages: ['corechart', 'geochart']
});
var app = angular.module('ccomp',['plupload.module','ivpusic.cookie','ui.bootstrap','ngRoute','ngAnimate','ccomp.directives','ccomp.services','ccomp.filters','colorpicker.module'])
    .config(['$routeProvider','$locationProvider', function($routeProvider,$locationProvider){
    $routeProvider.when('/login', {templateUrl:'partials/login.html', controller:'LoginCtrl'});
    $routeProvider.when('/login_error', {templateUrl:'partials/login_error.html', controller:'LoginErrorCtrl'});
    $routeProvider.when('/password_recovery',{templateUrl:'partials/password_recovery.html',controller:'PasswordRecoveryCtrl'});
    $routeProvider.when('/registration',{templateUrl:'partials/registration.html',controller:'RegistrationCtrl'});
    $routeProvider.when('/home', {templateUrl:'partials/home.html', controller:'HomeCtrl'});
    $routeProvider.when('/classes', {templateUrl:'partials/classes.html', controller:'ClassroomCtrl'});
    $routeProvider.when('/assigned_challenges',{templateUrl:'partials/assigned_challenges.html', controller:'AssignedChallengesCtrl'});
    $routeProvider.when('/question/challenge/:id', {templateUrl:'partials/question.html', controller:"QuestionCtrl"});
    $routeProvider.when('/content_builder',{templateUrl:'partials/content_builder.html', controller:'ContentBuilderCtrl'});
    $routeProvider.when('/marketplace',{templateUrl:'partials/marketplace.html', controller:'MarketplaceCtrl'});
    $routeProvider.when('/basic_report', {templateUrl:'partials/basic_reports.html', controller:'BasicReportCtrl'});
    $routeProvider.when('/statistic_report', {templateUrl:'partials/statistic_reports.html', controller:'StatisticReportCtrl'});
    $routeProvider.when('/profile', {templateUrl:'partials/profile.html', controller:"ProfileCtrl"});
    $routeProvider.when('/', {redirectTo:'/home'});
    $routeProvider.otherwise('/home');

}]);

app.run(['$rootScope','$location','$http','ipCookie','LoginResource',function($rootScope, $location, $http, ipCookie, LoginResource){

    $rootScope.$on( "$routeChangeStart", function(event, next, current) {

        if((next.originalPath !== "/registration" && next.originalPath !== "/password_recovery" && next.originalPath !== '/login_error' && next.originalPath !== '/login' ) && angular.isUndefined(ipCookie('classcompete'))){
            $location.path('/login');
        }
        if(next.originalPath !== "/registration" && next.originalPath !== "/password_recovery" && next.originalPath !== '/login_error' && next.originalPath !== '/login'){
            LoginResource.is_logged().$promise.then(function(data){
                $rootScope.user          = data;
                $rootScope.teacher_image = data.teacher_image;
            });
        }

        $rootScope.subNavChallenges = false;
        $rootScope.subNavReports = false;

        if(next.templateUrl === 'partials/challenge.html' || next.templateUrl === 'partials/assigned_challenges.html' || next.templateUrl === 'partials/content_builder.html' || next.templateUrl === 'partials/marketplace.html' || next.templateUrl === 'partials/question.html'){
            $rootScope.subNavChallenges = true;
        }else if(next.templateUrl === 'partials/reports.html'){
            $rootScope.subNavReports = true;
        }
    });

    $rootScope.images_url   = "http://images.classcompete.dev-o-matic.org/images/";
    $rootScope.images_upload_url = "http://images.classcompete.dev-o-matic.org/upload/";
    $rootScope.teacher_image_upload = "http://images.classcompete.dev-o-matic.org/teacher_image";
    $rootScope.question_image = "http://images.classcompete.dev-o-matic.org/question_image";
    $rootScope.choice_image = "http://images.classcompete.dev-o-matic.org/question_choice_image";
    $rootScope.image_maker = "http://images.classcompete.dev-o-matic.org/image_maker";

    $http.defaults.headers.common['X-API-KEY'] = ipCookie('classcompete');
}]);