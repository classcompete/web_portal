angular.module('ccomp').controller('LoginCtrl',function($http,$scope, $rootScope, LoginResource, $location, ipCookie ,ErrorService){
    $.backstretch('http://cdn.classcompete.com/images/kids-bg-1.jpg');
    $('#view-animate-container').removeClass('view-animate-container');
    $('#dashboard-wrapper').removeClass('dashboard-wrapper');

    $scope.user_data = {};
    $scope.user_data.username = null;
    $scope.ErrorService = ErrorService;

    $scope.submit = function(form){
        var $my_form = $('#'+form.$name);

        $my_form.validate(function($form, e){
            if(angular.isUndefined(e) === false){
                $scope.$apply(function(){
                    LoginResource.login($scope.user_data).$promise.then(function(data){
                        ipCookie('classcompete', data.user_data, { expires: 7, path: '/'});
                        $http.defaults.headers.common['X-API-KEY'] = ipCookie('classcompete');
                        $rootScope.user         = {};
                        $rootScope.user.logged  = true;
                        $location.path('/home');

                        LoginResource.is_logged().$promise.then(function(data){
                            $rootScope.user          = data;
                            $rootScope.teacher_image = data.teacher_image;
                        });
                        $('#dashboard-wrapper').addClass('dashboard-wrapper');
                    });
                });
            }
        });
    }
});