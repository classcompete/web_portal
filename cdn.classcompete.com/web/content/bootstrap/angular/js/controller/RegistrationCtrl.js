angular.module('ccomp').controller('RegistrationCtrl',function($scope, $rootScope, $location, $http, ipCookie, ErrorService, RegistrationResource, LoginResource, SchoolResource){

    $('.view-animate').removeClass('view-animate');
    $('#dashboard-wrapper').removeClass('dashboard-wrapper');
    $.backstretch('http://cdn.classcompete.com/images/kids-bg-1.jpg');
    $scope.ErrorService = ErrorService;
    $scope.new_teacher = {};
    $scope.new_teacher.grade = {};

    $scope.signUp = function(){

        RegistrationResource.save($scope.new_teacher).$promise.then(function(data){

            ipCookie('classcompete', data.user_data, { expires: 7, path: '/'});
            $http.defaults.headers.common['X-API-KEY'] = ipCookie('classcompete');

            LoginResource.is_logged().$promise.then(function(data){
                $rootScope.user = data;
                $rootScope.teacher_image = data.teacher_image;
            });

            $location.path('/home');
            $('#dashboard-wrapper').addClass('dashboard-wrapper');
        });
    };

});