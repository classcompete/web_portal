'use strict';

var IntroCtrl = function($location, Security, AccountFactory){
    this.location = $location;
    this.security = Security;
    this.AccountFactory = AccountFactory;
};

IntroCtrl.prototype.ready = function(){
    this.security.setRole(3);
    this.AccountFactory.update_intro();
    this.location.path('/home');
};
IntroCtrl.$inject = ['$location','Security','AccountFactory'];
angular.module('intro').controller('IntroCtrl', IntroCtrl);
