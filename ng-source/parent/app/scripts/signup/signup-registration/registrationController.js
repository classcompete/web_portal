'use strict'

var RegistrationCtrl = function($rootScope, $log, Security, $location, RegisterValidation, NotificationService, CountryFactory){

    var self = this;
    this.location = $location;
    this.security = Security;
    this.registerValidation = RegisterValidation;
    this.notification = NotificationService;

    this.user = {country:'',postalCode:'',firstName:'',lastName:'',email:'',username:'',password:'',retypePassword:''};

    this.countries = [];

    CountryFactory.query().$promise.then(function(r){
        self.countries = r;
    });

};

RegistrationCtrl.prototype.register = function(){
    var self = this;
    if(this.registerValidation.run(this.user) === false){
        this.notification.showMessage(this.registerValidation.getErrors(), 'Registration form', 'error');
        return;
    }

    this.security.register(this.user).then(function(loggedIn){
        if(!loggedIn){
//            self.notification.error('Bad credentials!','Registration from');
        }else{
            self.location.path('/setup_student');
        }
    });
};

RegistrationCtrl.$inject = ['$rootScope','$log','Security','$location','RegisterValidation','NotificationService','CountryFactory'];
angular.module('signup-registration').controller('RegistrationCtrl',RegistrationCtrl);