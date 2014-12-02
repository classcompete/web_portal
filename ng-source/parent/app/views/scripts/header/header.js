'use strict'

angular.module('header',[])
    .directive('headerNavigation', ['Security', function (Security) {
        return {
            templateUrl: 'views/header.html',
            restrict: 'E',
            replace:true,
            controller:HeaderCtrl,
            link: function postLink(scope, element, attrs) {
            }
        };
    }]);