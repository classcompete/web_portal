'use strict'
var LoginCtrl = function($rootScope, $log, Security, $location, LoginValidation, NotificationService, CredentialValidation, CredentialsFactory, ACCESS_LEVEL){
    this.rootScope = $rootScope;
    this.security = Security;
    this.location = $location;
    this.loginValidation = LoginValidation;
    this.credentialValidation = CredentialValidation;
    this.notification = NotificationService;
    this.credentialsFactory = CredentialsFactory;
    this.forgotCredentialsView = false;
    this.forgotCredentials = {email:''};
    this.user = {username:'',password:''};
    this.ACCESS_LEVEL = ACCESS_LEVEL;

};

LoginCtrl.prototype.login = function(){
    var self = this;
    if(this.loginValidation.run(this.user) === false){
        this.notification.showMessage(this.loginValidation.getErrors(),'Login form', 'error');
        return;
    }

    this.security.login(this.user).then(function(loggedIn){
        if(loggedIn.intro === self.ACCESS_LEVEL.registered){
            self.location.path('/setup_student');
        }else if(loggedIn.intro === self.ACCESS_LEVEL.auth && loggedIn.valid){
            self.location.path('/home');
        }
    });

};

LoginCtrl.prototype.requestCredentials = function(){
    var self = this;
    if(this.credentialValidation.run(this.forgotCredentials) === false){
        this.notification.showMessage(this.credentialValidation.getErrors(),'Forgot credentials','error')
        return;
    }

    this.credentialsFactory.save(this.forgotCredentials).$promise.then(function(r){
        self.notification.info(r.message,'Info')
    });
};

LoginCtrl.$inject = ['$rootScope','$log','Security','$location','LoginValidation','NotificationService','CredentialValidation','CredentialsFactory','ACCESS_LEVEL'];
angular.module('signup-login').controller('LoginCtrl',LoginCtrl);