angular.module('ccomp').controller('BasicReportCtrl', function ($scope, $rootScope, $location, GeoChartResource, ClassroomResource, ChallengeScoreResource,ChallengeStatResource, ClassScoreResource,StudentStatResource){

    $rootScope.mainLoading = true;

    GeoChartResource.get().$promise.then(function(response){
        $scope.geoChartData = response.geoChartData;
    });

    ClassroomResource.getAll().$promise.then(function(response){
        $scope.classrooms   =  response.class_list;

        $scope.selectedClassStudentChallenges = $scope.classrooms[0];
        $scope.selectedClassTopStudent = $scope.classrooms[0];
        $scope.selectedClassBottomStudent = $scope.classrooms[0];

        ChallengeScoreResource.getStudentsScoreChallengesByClass({class_id:$scope.classrooms[0].class_id}).$promise.then(function(response){
            $scope.chartDataStudentChallenges = response.chart_data;
        });

        StudentStatResource.getTopThreeByClass({class_id:$scope.selectedClassTopStudent.class_id}).$promise.then(function(response){
            $scope.top_students = response.top_students;
        });

        StudentStatResource.getTopBottomByClass({class_id:$scope.selectedClassBottomStudent.class_id}).$promise.then(function(response){
            $scope.bottom_students = response.bottom_students;
        });

        $rootScope.mainLoading = false;
    });

    ChallengeStatResource.getTopThreeChallenge().$promise.then(function(response){
        $scope.top_challenges = response.top_challenges;
    });

    ClassScoreResource.getTopThreeClass().$promise.then(function(response){
        $scope.top_classes = response.class_statistic;
    });


    $scope.changeClassStudentChartData = function(change_class){
        ChallengeScoreResource.getStudentsScoreChallengesByClass({class_id:change_class.class_id}).$promise.then(function(response){
            $scope.chartDataStudentChallenges = response.chart_data;
        });
    };

    $scope.changeTopStudentChartData = function(selected_class){
        StudentStatResource.getTopThreeByClass({class_id:selected_class.class_id}).$promise.then(function(response){
            $scope.top_students = response.top_students;
            console.log($scope.top_students);
        });
    };

    $scope.changeBottomStudentChartData = function(selected_class){
        StudentStatResource.getTopBottomByClass({class_id:selected_class.class_id}).$promise.then(function(response){
            $scope.bottom_students = response.bottom_students;
        });
    };

});