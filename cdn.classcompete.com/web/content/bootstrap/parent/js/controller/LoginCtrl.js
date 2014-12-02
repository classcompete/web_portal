angular.module('parent-app').controller('LoginCtrl',function($scope, $rootScope, $location,$http, LoginResource, ipCookie, $FB, SocialLoginResource, ErrorService){
    $.backstretch('http://cdn.classcompete.com/images/kids-bg-1.jpg');
    $('#view-animate-container').removeClass('view-animate-container');
    $('#dashboard-wrapper').removeClass('dashboard-wrapper');
    $rootScope.mainLoading = false;
    $scope.ErrorService = ErrorService;

    $scope.submit = function(form){
        var $my_form = $('#'+form.$name);

        $my_form.validate(function($form, e){
            if(angular.isUndefined(e) === false){
                $scope.$apply(function(){

                    LoginResource.login($scope.user_data).$promise.then(function(data){
                        ipCookie('parent-classcompete', data.user_data, { expires: 7, path: '/'});
                        $http.defaults.headers.common['X-API-KEY'] = ipCookie('parent-classcompete');
                        $rootScope.user         = {};
                        $rootScope.user.logged  = true;
                        $location.path('/children');

                    });
                });
            }
        });
    };

    $scope.$on('event:google-plus-sign-success', function (event,authResult) {
        gapi.client.load('plus','v1', function(){
            var request = gapi.client.plus.people.get( {'userId' : 'me'} );
            request.execute(function(resp) {
                email = resp['emails'].filter(function(v) {
                    return v.type === 'account';
                })[0].value;
                var g_reg_data = {
                    'first_name' : resp.name.givenName,
                    'last_name' : resp.name.familyName,
                    'email':email,
                    'code':resp.id,
                    'social':'google'
                };

                SocialLoginResource.login(g_reg_data).$promise.then(function(response){
                    ipCookie('parent-classcompete', response.user_data, { expires: 7, path: '/'});
                    $http.defaults.headers.common['X-API-KEY'] = ipCookie('parent-classcompete');
                    $rootScope.user         = {};
                    $rootScope.user.logged  = true;
                    $location.path('/children');
                    gapi.auth.signOut();
                });
            });
        });

    });

    $scope.facebook_login = function(){
        $FB.login(function(res){
            if(res.authResponse){
                $FB.api('/me',function(userInfo){
                    console.log(userInfo);
                    var data = {
                        social: 'facebook',
                        code:userInfo.id,
                        email:userInfo.email,
                        first_name:userInfo.first_name,
                        last_name:userInfo.last_name
                    };
                    SocialLoginResource.login(data).$promise.then(function(response){
                        ipCookie('parent-classcompete', response.user_data, { expires: 7, path: '/'});
                        $http.defaults.headers.common['X-API-KEY'] = ipCookie('parent-classcompete');
                        $rootScope.user         = {};
                        $rootScope.user.logged  = true;
                        $location.path('/children');
                    });
                });
            }
        },{scope:'email'});
    };

    $scope.getLinkedInDataLogin = function() {
        if(!$scope.hasOwnProperty("userprofile")){
            IN.API.Profile("me").fields([ "id", "firstName", "lastName","email-address" ]).result(function(result) {
                    var data = {};
                    data.social = 'linkedin';
                    data.parent_mail = result.values[0].emailAddress;
                    data.code = result.values[0].id;
                    SocialLoginResource.login(data).$promise.then(function(response){
                        ipCookie('parent-classcompete', response.user_data, { expires: 7, path: '/'});
                        $http.defaults.headers.common['X-API-KEY'] = ipCookie('parent-classcompete');
                        $rootScope.user         = {};
                        $rootScope.user.logged  = true;
                        $location.path('/children');
                    });
                }).error(function(err) {
                    $scope.error = err;
                });
        }
    };
});