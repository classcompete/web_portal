angular.module('ccomp').controller('LoginErrorCtrl',function($scope, $location, ErrorService){

    $('.view-animate').removeClass('view-animate');
    $('#dashboard-wrapper').removeClass('dashboard-wrapper');
    $.backstretch('http://cdn.classcompete.com/images/kids-bg-1.jpg');
    $scope.ErrorService = ErrorService;

});