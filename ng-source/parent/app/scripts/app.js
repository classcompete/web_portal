'use strict';

angular.module('ccompparentApp',['ngAnimate','ngCookies','ngRoute','ngSanitize',
                                'ngResource','Config','angular-loading-bar',
                                'signup','security','home','navigation',
                                'header','classcode','students','support','shop',
                                'account','accountRecovery','localytics.directives',
                                'directives','httpInterceptor','ezfb','navigationService','ui.bootstrap',
                                'angulartics', 'angulartics.google.tagmanager'])
    .config(['$routeProvider','ezfbProvider','SOCIAL_ID','$httpProvider','cfpLoadingBarProvider', '$analyticsProvider', function($routeProvider, ezfbProvider, SOCIAL_ID,$httpProvider, cfpLoadingBarProvider, $analyticsProvider){
        $analyticsProvider.firstPageview(true); /* Records pages that don't use $state or $route */
        $analyticsProvider.withAutoBase(true);  /* Records full path */

        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $routeProvider.otherwise({redirectTo:'/signup'});
        ezfbProvider.setInitParams({
            appId:SOCIAL_ID.FACEBOOK_ID
        });

        cfpLoadingBarProvider.includeSpinner  = false;
    }])
    .run(['Security','$rootScope','$location','ACCESS_LEVEL','IMG', function(Security, $rootScope, $location, ACCESS_LEVEL, IMG){
        $rootScope.imageUrl = IMG.url;
        Security.requestCurrentUser();

        $rootScope.$on('$routeChangeStart', function(event, curr, prev){
                if(Security.isAuthenticated() && curr.originalPath === '/signup'){
                    Security.logout();
                }
        });
    }]);