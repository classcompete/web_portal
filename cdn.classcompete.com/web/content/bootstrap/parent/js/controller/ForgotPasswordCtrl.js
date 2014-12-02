angular.module('parent-app').controller('ForgotPasswordCtrl',['$scope','ForgotPassword', function($scope, ForgotPassword){

    $scope.email = '';


    $scope.resetPwd = function(){
        ForgotPassword.save({email:$scope.email}).$promise.then(function(response){
            $scope.success_message = response.message;
        });
    };


}]);