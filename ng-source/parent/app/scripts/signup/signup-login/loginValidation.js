'use strict';
var LoginValidation = function(BaseValidation){

    var rules = [];

    rules.push({ name: 'username'   ,   display: 'Login username'   ,   rules: 'required|min_length[5]'});
    rules.push({ name: 'password'   ,   display: 'Login password'   ,   rules: 'required|min_length[5]'});

    var validate = new BaseValidation(rules);

    this.run = function(obj){
        return validate.run(obj);
    };

    this.getErrors = function(){
        return validate.getErrors();
    };

};

LoginValidation.$inject = ['BaseValidation'];
angular.module('signup-login').service('LoginValidation',LoginValidation);
