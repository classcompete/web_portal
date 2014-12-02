'use strict';

var AccountCtrl = function(accountData, AccountValidation, NotificationService, AccountFactory, NavigationService,countries){
    $(window).width() < 1024 ? NavigationService.showMainNav() : NavigationService.menu(1);
    this.notification = NotificationService;
    this.accountValidation = AccountValidation;
    this.accountFactory = AccountFactory;
    this.user = accountData;
    this.countries = countries;
};

AccountCtrl.resolve ={
    accountData: ['$q','AccountFactory', function($q, AccountFactory){
        var deferred = $q.defer();
        AccountFactory.get().$promise.then(function(r){
            deferred.resolve(r);
        });
        return deferred.promise;
    }],
    countries: ['$q','CountryFactory', function($q, CountryFactory){
        var deferred = $q.defer();
        CountryFactory.query().$promise.then(function(r){
            deferred.resolve(r)
        });
        return deferred.promise;
    }]
};

AccountCtrl.prototype.save = function(){
    var self = this;
    if(this.accountValidation.run(this.user) === false){
        this.notification.showMessage(this.accountValidation.getErrors(),'Account form','error');
        return;
    }

    this.accountFactory.edit(this.user).$promise.then(function(r){
        self.notification.success(r.message,'Account data');
    });

};

AccountCtrl.$inject = ['accountData','AccountValidation','NotificationService','AccountFactory','NavigationService','countries'];
angular.module('account').controller('AccountCtrl', AccountCtrl);