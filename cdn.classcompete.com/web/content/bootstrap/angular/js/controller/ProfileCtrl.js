angular.module('ccomp').controller('ProfileCtrl', function($scope, $rootScope, $location, ProfileResource, ErrorService, $route){

    $rootScope.mainLoading = true;
    $scope.ErrorService = ErrorService;
    $scope.percent = '';
    $scope.files = [];

    ProfileResource.get().$promise.then(function(data){
        $scope.new_teacher        = data.teacher_info;
        $scope.new_teacher.grades = data.teacher_grades;
        $rootScope.mainLoading = false;
    });

    $scope.editProfile = function(form){
        var $my_form = $('#'+form.$name);
        $my_form.validate(function($form, e){
            if(angular.isDefined(e)){
                ProfileResource.edit($scope.new_teacher).$promise.then(function(){
                    ErrorService.clearError();
                    toastr.success("Your profile is updated!");
                });
            }
        });
    };

    $scope.updateProfileImageView = function(){
        $rootScope.image_changed = true;
        $rootScope.user.teacher_image = $rootScope.user.teacher_image + '?decache=' + Math.random();
        $scope.new_teacher.image_thumb = $scope.new_teacher.image_thumb + '?decache=' + Math.random();
    };
});