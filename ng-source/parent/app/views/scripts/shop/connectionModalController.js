var ConnectionModalCtrl = function($scope, $modalInstance, students, selectedClass, ClassConnectionFactory,NotificationService){

    $scope.students = students;
    $scope.class = selectedClass;
    $scope.selectedStudents = {};

    $scope.assign = function(){
        var data = {
            'students':$scope.selectedStudents.list,
            'class':$scope.class.classId
        };
        ClassConnectionFactory.save(data).$promise.then(function(data){
            NotificationService.showMessage(null,data.message,'success');
            $modalInstance.close($scope.selectedStudents.list);
        });
    };

    $scope.cancel = function(){
        $modalInstance.dismiss();
    }

};

ConnectionModalCtrl.$inject = ['$scope','$modalInstance','students','selectedClass','ClassConnectionFactory','NotificationService'];
angular.module('shop').controller('ConnectionModalCtrl',ConnectionModalCtrl);