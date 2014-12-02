'use strict';

angular.module('security.interceptor',[])
    .factory('Interceptor',['$q','$location', function ($q,$location) {
        var interceptor = {
            'request': function(config) {
                // Successful request method
                return config; // or $q.when(config);
            },
            'response': function(response) {
                // successful response
                return response; // or $q.when(config);
            },
            'requestError': function(rejection) {
                // an error happened on the request
                // if we can recover from the error
                // we can return a new request
                // or promise
                return rejection; // or new promise
                // Otherwise, we can reject the next
                // by returning a rejection
                // return $q.reject(rejection);
            },
            'responseError': function(rejection) {
                if(rejection.status === 401){
                    $location.path('/signup')
                }
                // an error happened on the request
                // if we can recover from the error
                // we can return a new response
                // or promise
                return $q.reject(rejection); // or new promise
                // Otherwise, we can reject the next
                // by returning a rejection
                // return $q.reject(rejection);
            }
        };
        return interceptor;
    }])
    .config(['$httpProvider', function($httpProvider){
        $httpProvider.interceptors.push('Interceptor');
    }]);
