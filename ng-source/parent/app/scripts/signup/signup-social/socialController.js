'use strict'

var SocialCtrl = function(ezfb, Security, $location, SOCIAL_ID, $scope){
    this.ezfb = ezfb;
    this.security = Security;
    this.$location = $location;
    this.SOCIAL_ID = SOCIAL_ID;
    var self = this;
    $scope.$on('event:google-plus-sign-success', function (event,authResult) {
        gapi.client.load('plus','v1', function(){
            var request = gapi.client.plus.people.get( {'userId' : 'me'} );
            request.execute(function(resp) {
                var email = resp['emails'].filter(function(v) {
                    return v.type === 'account';
                })[0].value;
                var g_reg_data = {
                    'firstName' : resp.name.givenName,
                    'lastName' : resp.name.familyName,
                    'email':email,
                    'code':resp.id,
                    'social':'google'
                };
                self.security.loginGoogle(g_reg_data).then(function(data){
                    if(data.loggedIn){
                        if(data.type === "new")self.$location.path('/setup_student');
                        else self.$location.path('/home');
                    }

                });
            });
        });

    });
};


SocialCtrl.prototype.facebookLogin = function(){
    var self = this;
    this.ezfb.login(function(res){
        if(res.authResponse){
            self.ezfb.api('/me',function(userInfo){
                var data = {
                    code: userInfo.id,
                    email:userInfo.email,
                    firstName:userInfo.first_name,
                    lastName:userInfo.last_name
                };
                self.security.loginFacebook(data).then(function(data){
                    if(data.loggedIn){
                        if(data.type === "new")self.$location.path('/setup_student');
                        else self.$location.path('/home');
                    }

                });
            });
        }
    },{scope:'email'});
};

SocialCtrl.$inject = ['ezfb','Security', '$location','SOCIAL_ID', '$scope'];
angular.module('signup.social').controller('SocialCtrl', SocialCtrl);