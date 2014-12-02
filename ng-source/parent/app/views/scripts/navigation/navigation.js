'use strict'

angular.module('navigation',{})
    .directive('mainNavigation',[function () {
        return {
            templateUrl: 'views/navigation.html',
            restrict: 'E',
            replace:true,
            compile:function(scope, element, attrs){
                $(window).resize(function(e){
                    $(window).height() < 650 ? $('.navigation').addClass('small-navigation') : $('.navigation').removeClass('small-navigation');
                });
            },
            controller:function(){
                $(window).height() < 650 ? $('.navigation').addClass('small-navigation') : $('.navigation').removeClass('small-navigation');
            }
        };
    }]);
	
