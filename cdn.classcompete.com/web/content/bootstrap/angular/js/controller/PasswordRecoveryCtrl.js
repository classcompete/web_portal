angular.module('ccomp').controller('PasswordRecoveryCtrl',function($scope,$location, PwdRecoveryResource, ErrorService){

    $('.view-animate').removeClass('view-animate');
    $('#dashboard-wrapper').removeClass('dashboard-wrapper');
    $.backstretch('http://cdn.classcompete.com/images/kids-bg-1.jpg');
    $scope.ErrorService = ErrorService;
    $scope.email = null;

    $scope.submit = function(){
        PwdRecoveryResource.save({email:$scope.email}).$promise.then(function(){
            $location.path('/login');
            toastr.info('Check you email for new password!');
        });
    };
});
