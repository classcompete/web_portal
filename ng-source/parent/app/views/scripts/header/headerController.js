'use strict'

var HeaderCtrl = function($scope,Security){

    $scope.showHeader = Security.isAuthenticated;

    $scope.$watch(function() {
        return Security.currentUser;
    }, function(currentUser) {
        $scope.currentUser = currentUser;
    });
};


HeaderCtrl.$inject = ['$scope','Security'];
angular.module('header').controller('HeaderCtrl',HeaderCtrl);