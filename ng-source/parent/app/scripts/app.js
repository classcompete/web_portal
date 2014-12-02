'use strict';

angular.module('ccompparentApp',['ngAnimate','ngCookies','ngRoute','ngSanitize',
                                'ngResource','Config','angular-loading-bar',
                                'signup','security','home','navigation',
                                'header','classcode','students','support','shop',
                                'account','accountRecovery','localytics.directives',
                                'directives','httpInterceptor','ezfb','navigationService','ui.bootstrap',
                                'angularytics'])
    .config(['$routeProvider','ezfbProvider','SOCIAL_ID','$httpProvider','cfpLoadingBarProvider', 'AngularyticsProvider', function($routeProvider, ezfbProvider, SOCIAL_ID,$httpProvider, cfpLoadingBarProvider, AngularyticsProvider){
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $routeProvider.otherwise({redirectTo:'/signup'});
        ezfbProvider.setInitParams({
            appId:SOCIAL_ID.FACEBOOK_ID
        });

        cfpLoadingBarProvider.includeSpinner  = false;

        AngularyticsProvider.setEventHandlers(['Console', 'GoogleUniversal']);
    }])
    .run(['Security','$rootScope','$location','ACCESS_LEVEL','IMG','Angularytics', function(Security, $rootScope, $location, ACCESS_LEVEL, IMG, Angularytics){
        $rootScope.imageUrl = IMG.url;
        Security.requestCurrentUser();

        $rootScope.$on('$routeChangeStart', function(event, curr, prev){
                if(Security.isAuthenticated() && curr.originalPath === '/signup'){
                    Security.logout();
                }
        });
        Angularytics.init();
    }]);