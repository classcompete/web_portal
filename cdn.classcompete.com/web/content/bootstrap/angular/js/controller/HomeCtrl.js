angular.module('ccomp').controller('HomeCtrl',['$scope','$rootScope','$location','HomeResource','GeoChartResource',function($scope, $rootScope, $location, HomeResource, GeoChartResource){
    $('#view-animate-container').addClass('view-animate-container');
    angular.element('.backstretch').hide();

    $rootScope.mainLoading = true;


    GeoChartResource.get().$promise.then(function(response){
        $scope.geoChartData = response.geoChartData;
    });

    HomeResource.getAll().$promise.then(function(response){
        $scope.class_compete_total   = response.class_compete_total;
        $scope.top_five_challenges   = response.top_five_challenges;
        $scope.teacher_stats         = response.teacher_stats;

        $rootScope.mainLoading = false;
   });

}]);