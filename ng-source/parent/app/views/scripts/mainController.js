'use strict'

var MainCtrl = function($scope, $location, Security, NavigationService, ShoppingCart){

    $scope.isOpen = NavigationService.open;

    $scope.logout = function(){
        Security.logout();
        NavigationService.menuLogout();
        $location.path('/signup');
    };

    $scope.isActive = function (viewLocation) {
        return (viewLocation === $location.path());
    };

    $scope.loggedIn = function(){
        return Security.isAuthenticated();
    };

    $scope.menuOpen = function(){
         NavigationService.menu(NavigationService.open === 1? 0:1);
    };

    $scope.showCheckout = function(){
        return ShoppingCart.items.length > 0 ? true : false;
    };

    $scope.$watch(function() {
        return Security.currentUser;
    }, function(currentUser) {
        $scope.currentUser = currentUser;
    });

    $scope.goTo = function(){
        if($(window).width() < 1024){
            NavigationService.open = 0;
            $('body').animate({'padding-left':'0'});
            $('.main-nav ul').animate({'left':'-170px'});
            $('.main-nav-trigger').html('Open menu');
        }
    };
};

MainCtrl.$inject = ['$scope','$location','Security','NavigationService','ShoppingCart'];
angular.module('ccompparentApp').controller('MainCtrl',MainCtrl);
