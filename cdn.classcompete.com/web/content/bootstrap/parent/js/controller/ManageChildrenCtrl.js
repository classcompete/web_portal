angular.module('parent-app').controller('ManageChildrenCtrl',['$scope', '$rootScope', 'ChildResource', 'ErrorService',
    function($scope, $rootScope, ChildResource, ErrorService){
        $scope.ErrorService = ErrorService;


        $scope.$watch('ErrorService.errorMessage',function(){
            if(angular.isDefined(ErrorService.errorMessage)){
                angular.forEach(ErrorService.errorMessage, function(val,key){
                    toastr.error(val);
                });
            }
        });

        ChildResource.get().$promise.then(function(child_response){
            $scope.added_childrens = child_response.child;
        });

        $scope.addChild = function(form){
            var $my_form = $('#'+form.$name);

            $my_form.validate(function($form, e){
                if(angular.isUndefined(e) === false){
                    $scope.$apply(function(){
                        ChildResource.save($scope.children).$promise.then(function(response){
                            $scope.loadingTableData = true;
                            ChildResource.get().$promise.then(function(child_response){
                                $scope.added_childrens = child_response.child;
                                $scope.children = {};
                                $scope.loadingTableData = false;
                            })
                        });
                    });
                }
            });
        }
    }
]);