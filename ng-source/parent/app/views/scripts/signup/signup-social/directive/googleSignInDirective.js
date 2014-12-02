angular.module('signup.social').directive('googlesignin',['$window','SOCIAL_ID',function($window,SOCIAL_ID){
    return{
        restrict:'A',
        controller:function($scope){
            $scope.google_login = function(){
                gapi.auth.signIn({
                    'clientid' : SOCIAL_ID.GOOGLE_ID,
                    'cookiepolicy' : 'single_host_origin',
                    'callback' : 'googleSigninCallback',
                    requestvisibleactions: 'http://schemas.google.com/AddActivity',
                    'data-cookiepolicy':"single_host_origin",
                    'scope':"https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read"
                })
            };

            $window.googleSigninCallback = function (authResult) {
                if(authResult && authResult.access_token){
                    $scope.$broadcast('event:google-plus-sign-success',authResult);
                }
                else{
                    $scope.$broadcast('event:google-plus-sign-failure',authResult);
                }
            };

            // Asynchronously load the G+ SDK.
            (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/client:plusone.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();
        }
    }
}]);