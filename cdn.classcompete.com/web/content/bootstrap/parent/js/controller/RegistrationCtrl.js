angular.module('parent-app').controller('RegistrationCtrl', ['$scope', '$rootScope', '$http', '$location', '$FB', 'RegistrationResource', 'ErrorService', 'ipCookie', 'RegistrationFacebookResource','RegistrationGoogleResource',
    function($scope, $rootScope, $http, $location, $FB, RegistrationResource, ErrorService, ipCookie, RegistrationFacebookResource, RegistrationGoogleResource){
        $.backstretch('http://cdn.classcompete.com/images/kids-bg-1.jpg');
        $('#dashboard-wrapper').removeClass('dashboard-wrapper');
        $scope.new_parent = {username:'',password:'',email:'',repassword:'',first_name:'',last_name:''};
        $scope.ErrorService = ErrorService;

        $scope.signUp = function(){
            RegistrationResource.save($scope.new_parent).$promise.then(function(reg_response){
                ipCookie('parent-classcompete', reg_response.user_data, { expires: 7, path: '/'});
                $http.defaults.headers.common['X-API-KEY'] = ipCookie('parent-classcompete');
                $location.path('/children');
                $('#dashboard-wrapper').addClass('dashboard-wrapper');
            });
        };

        $scope.facebook_register = function(){
            $FB.login(function(res){
                if(res.authResponse){
                    $FB.api('/me',function(userInfo){
                        console.log(userInfo);
                        var data = {
                            id:userInfo.id,
                            email:userInfo.email,
                            first_name:userInfo.first_name,
                            last_name:userInfo.last_name
                        };
                        RegistrationFacebookResource.save(data).$promise.then(function(fb_reg_response){
                            ipCookie('parent-classcompete', fb_reg_response.user_data, { expires: 7, path: '/'});
                            $http.defaults.headers.common['X-API-KEY'] = ipCookie('parent-classcompete');
                            $location.path('/children');
                            $('#dashboard-wrapper').addClass('dashboard-wrapper');
                        });
                    });
                }
            },{scope:'email'});
        };

        $scope.$on('event:google-plus-signup-success', function (event,authResult) {

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
                        'id':resp.id
                    };
                    RegistrationGoogleResource.save(g_reg_data).$promise.then(function(g_reg_response){
                        ipCookie('parent-classcompete', g_reg_response.user_data, { expires: 7, path: '/'});
                        $http.defaults.headers.common['X-API-KEY'] = ipCookie('parent-classcompete');
                        $location.path('/children');
                        $('#dashboard-wrapper').addClass('dashboard-wrapper');
                    });
                });
            });

        });
    }
]);