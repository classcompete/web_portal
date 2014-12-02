'use strict';
var CredentialValidation = function(BaseValidation){

    var rules = [];

    rules.push({ name: 'email'   ,   display: 'Email'   ,   rules: 'required|valid_email'});

    var validate = new BaseValidation(rules);

    this.run = function(obj){
        return validate.run(obj);
    };

    this.getErrors = function(){
        return validate.getErrors();
    };

};

CredentialValidation.$inject = ['BaseValidation'];
angular.module('signup-login').service('CredentialValidation',CredentialValidation);
