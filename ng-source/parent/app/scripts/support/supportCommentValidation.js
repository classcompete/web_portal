'use strict';
var SupportCommentValidation = function(BaseValidation){

    var rules = [];

    rules.push({ name: 'name'    ,   display: 'Name'    ,   rules:'required'});
    rules.push({ name: 'email'   ,   display: 'Email'   ,   rules: 'required|valid_email'});
    rules.push({ name: 'comment'   ,   display: 'Comment'   ,   rules: 'required'});

    var validate = new BaseValidation(rules);

    this.run = function(obj){
        return validate.run(obj);
    };

    this.getErrors = function(){
        return validate.getErrors();
    };

};

SupportCommentValidation.$inject = ['BaseValidation'];
angular.module('support').service('SupportCommentValidation',SupportCommentValidation);
