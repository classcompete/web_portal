angular.module('parent-app').controller('DefaultCtrl',function($scope, $rootScope, $location, $http, ipCookie){
    $('#dashboard-wrapper').removeClass('dashboard-wrapper');
    $rootScope.$on('event:loginRequired', function(){
        $location.path('/login');
    });

    var templates =[ { name: 'header.html'  , url: 'partials/header.html'},
        { name: 'menu.html'    , url: 'partials/navigation/menu.html'},
        { name: 'footer.html'  , url:'partials/footer.html'}];

    $scope.header_tmpl = templates[0];
    $scope.menu_tmpl   = templates[1];
    $scope.footer_tmpl = templates[2];

    $scope.logout = function(){
        $('#dashboard-wrapper').removeClass('dashboard-wrapper');
        ipCookie.remove('parent-classcompete');
        $http.defaults.headers.common['X-API-KEY'] = null;
        $rootScope.user = {};
        $location.path('/login');
    }
});