angular.module('ccomp').controller('MarketplaceCtrl',function($scope, $rootScope, $location,$modal, MarketplaceResource, SubjectResource){

    $rootScope.mainLoading = true;

    MarketplaceResource.get({id:'pre_k'}).$promise.then(function(data){
        $scope.challenges = data.challenges;
        $rootScope.mainLoading = false;
    });


    SubjectResource.get().$promise.then(function(data){
        $scope.subjects = data;
        $scope.selected_subject = false;
    });

    $scope.getChallenges = function(index){

        MarketplaceResource.get({id:index}).$promise.then(function(data){
            if(data.empty === true){
                $scope.challenges = {};
            }else{
                $scope.challenges = data.challenges;
            }

        });
    };

    $scope.hideChallenge = function(subject){
        if(subject !== null){
            $scope.selected_subject = subject.subject_id;
        }else{
            $scope.selected_subject = false;
        }
    };

    $scope.showPowerTip = function(){
        $('.marketplace_thumb').hover(function () {
            var tooltip_content = $(this).parents('.challenge').next().html();
            var tooltip_html = $('<div style="width: 380px">' + tooltip_content + '</div>');
            $('.thumbnail_challenge').data('powertipjq', tooltip_html);
        });

        $('.marketplace_thumb').powerTip({
            placement: 'e',
            smartPlacement: true,
            mouseOnToPopup: true
        });
    };

    $scope.installChallenge = function(index,challenge){

        var modalRemoveInstance = $modal.open({
            templateUrl:'partials/modals/install_challenge.html',
            controller:'InstallChallengeController',
            windowClass:'classmodal',
            backdrop:'static',
            resolve:{
                challenge: function(){
                    return challenge;
                }
            }
        });

        modalRemoveInstance.result.then(function(){
            toastr.success($scope.challenges[index].challenge_name,'Challenge successfully installed in class');
        });
    };
});
angular.module('ccomp').controller('InstallChallengeController',function($scope, $modalInstance, challenge, ClassroomResource, MarketplaceResource,ErrorService){

    $scope.ErrorService  = ErrorService;
    $scope.class = {};

    ClassroomResource.getAvailable({id:challenge}).$promise.then(function(data){
        if(data.class_list){
            $scope.classes = data.class_list;
        }else{
            $scope.no_classes = true;
        }

    });

//    $scope.selectClass = function(selectedClass){
//        $scope.classInstall = selectedClass;
//    };

    $scope.ok = function(form){
        var $my_form = $('#'+form.$name);
        $my_form.validate(function($form, e){
            if(angular.isDefined(e)){
                MarketplaceResource.install({challenge:challenge, class:$scope.class.class_id}).$promise.then(function(){
                    $modalInstance.close();
                });
            }
        });
    };

    $scope.cancel = function(){
        ErrorService.clearError();
        $modalInstance.dismiss('close');
    };

});

