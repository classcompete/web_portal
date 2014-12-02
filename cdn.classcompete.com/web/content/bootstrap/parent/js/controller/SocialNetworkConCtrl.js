angular.module('parent-app').controller('SocialNetworkConCtrl',function($scope,$rootScope, SocialConnectionResource, $location, $http, $FB){

    $scope.mainLoading = true;
    SocialConnectionResource.getSocialNetworks().$promise.then(function(response){
        $scope.avaiable_social_networks = response.social_network;
        $scope.mainLoading = false;
    });

    $rootScope.$on( "$routeChangeStart", function(event, next, current) {
        if(next.originalPath === '/social_network_connections'){
            location.reload(true);
        }
    });

    $scope.removeSocial = function(soc_type, index){
        SocialConnectionResource.deleteNetwork({network_type:soc_type}).$promise.then(function(response){
            location.reload(true);
        });
    };

    $scope.$on('event:google-plus-connect-success', function (event,authResult) {
        gapi.client.load('plus','v1', function(){
            var request = gapi.client.plus.people.get( {'userId' : 'me'} );
            request.execute(function(resp) {
                var data = {};
                data.social = 'google';
                data.code = resp.id;
                gapi.auth.signOut();
                SocialConnectionResource.save(data).$promise.then(function(response){
                    if(response.added === true){
                        toastr.success('Google account successfully connected with parent portal!');
                    }
                    location.reload(true);
                });
            });
        });

    });
    $scope.$on('event:google-plus-connect-failure', function (event,authResult) {
        console.info('G+:');
        console.log('failure');
    });

    $scope.facebook_connect = function(){
        $FB.login(function(res){
            if(res.authResponse){
                var data = {};
                data.social = 'facebook';
                data.code = res.authResponse.userID;
                SocialConnectionResource.save(data).$promise.then(function(response){
                    toastr.success('Facebook account successfully connected with parent portal!');
                    $scope.avaiable_social_networks.facebook.added = true;
                });
            }
        },{scope:'email'});
    };

    $scope.$on('event:facebook-connect-success', function(name, response) {
        var data = {};
        data.social = 'facebook';
        data.code = response.id;
        SocialConnectionResource.save(data).$promise.then(function(response){
            if(response.added){
                toastr.success('Facebook account successfully connected with parent portal!');
            }
        });
    });


    $scope.getLinkedInData = function() {
        if(!$scope.hasOwnProperty("userprofile")){
            IN.API.Profile("me").fields(
                    [ "id", "firstName", "lastName","email-address" ]).result(function(result) {
                    var data = {};
                    data.social = 'linkedin';
                    data.parent_mail = result.values[0].emailAddress;
                    data.code = result.values[0].id;

                    SocialConnectionResource.save(data).$promise.then(function(response){
                        if(response.added){
                            toastr.success('Linked In account successfully connected with parent portal!');
                            $scope.avaiable_social_networks.linkedin.added = true;
                        }
                    });
                }).error(function(err) {
                    $scope.error = err;
                });
        }
    };

});