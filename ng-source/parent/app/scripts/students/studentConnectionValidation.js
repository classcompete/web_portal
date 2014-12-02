'use strict';

var StudentConnectionValidation = function(BaseValidation){


    var rules = [];

    rules.push({ name: 'username'       ,   display:    'Username'          ,   rules:  'required|min_length[6]'});
    rules.push({ name: 'password'       ,   display:    'Password'          ,   rules:  'required|min_length[3]'});


    var validate = null;

    this.run = function(obj){

        validate = new BaseValidation(rules);
        return validate.run(obj);
    };

    this.getErrors = function(){
        return validate.getErrors();
    };

};

StudentConnectionValidation.$inject = ['BaseValidation'];
angular.module('students').service('StudentConnectionValidation',StudentConnectionValidation);
