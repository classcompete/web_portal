'use strict'

var SupportCtrl = function(NavigationService, SupportCommentValidation, NotificationService, SupportFactory){
    $(window).width() < 1024 ? NavigationService.showMainNav() : NavigationService.menu(1);
    this.comment = {name:'',email:'',comment:''};
    this.SupportFactory = SupportFactory;
    this.SupportCommentValidation = SupportCommentValidation;
    this.NotificationService = NotificationService;
};

SupportCtrl.prototype.sendComment = function(){
    var self = this;
    if(this.SupportCommentValidation.run(this.comment) === false){
        this.NotificationService.showMessage(this.SupportCommentValidation.getErrors(),'Comment form', 'error');
        return;
    }
    this.SupportFactory.save(this.comment).$promise.then(function(r){
        self.NotificationService.success('Email successfully send!')
    });
};

SupportCtrl.resolve ={
};

SupportCtrl.$inject = ['NavigationService','SupportCommentValidation','NotificationService','SupportFactory'];
angular.module('support').controller('SupportCtrl',SupportCtrl);