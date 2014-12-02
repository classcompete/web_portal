angular.module('parent-app').controller('ProfileCtrl' , ['$scope','$rootScope','ProfileResource','ErrorService','TimezoneResource' ,
    function($scope, $rootScope, ProfileResource, ErrorService, TimezoneResource){

        $scope.ErrorService = ErrorService;
        $rootScope.mainLoading = true;
        $scope.percent = '';
        $scope.files = [];
        $scope.uploadedImage = [];
        $scope.selectedTimezone = null

        ProfileResource.get().$promise.then(function(response){
            $scope.parent = response.parent_info;
            TimezoneResource.get().$promise.then(function(t_res){
                $scope.timezones = t_res;
                angular.forEach($scope.timezones, function(val,key){
                    if(angular.isDefined($scope.parent.time_zone_diff)){
                        if(val.id === $scope.parent.time_zone_diff.id)
                            $scope.selectedTimezone = $scope.timezones[key];
                    }
                });
                $rootScope.mainLoading = false;
            });
        });

        $scope.selectTimezone = function(t){
            $scope.parent.timezone_diff = t.difference;
        };

        $scope.editProfile = function(form){
            var $my_form = $('#'+form.$name);
            $my_form.validate(function($form, e){
                if(angular.isDefined(e)){
                    ProfileResource.save($scope.parent).$promise.then(function(data){
                        toastr.success("Your profile is updated!");
                    });
                }
            });
        };

        $scope.$watch('percent',function(){
            if($scope.percent > 0){
                $scope.uploadingProfileImage = true;
            }
        });

        $scope.updateProfileImageView = function(){
            $rootScope.image_changed = true;
            $rootScope.user.parent_image = $rootScope.user.parent_image + '?decache=' + Math.random();
            $scope.parent.image_thumb = $scope.parent.image_thumb + '?decache=' + Math.random();
        };
    }]);