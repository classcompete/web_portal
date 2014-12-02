'use strict';

angular.module('httpInterceptor',[])
    .factory('Interceptor',['$q','$location','$rootScope','NotificationService', function ($q,$location,$rootScope,NotificationService) {
        var interceptor = {
            'request': function(config) {
                // Successful request method
                return config; // or $q.when(config);
            },
            'response': function(response) {
                // successful response
                NotificationService.clear();
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
                }else if(rejection.status === 400){
                    NotificationService.showMessage(rejection.data,'','error');
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
    }]);
