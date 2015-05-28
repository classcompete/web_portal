'use strict';

var RegisterValidation = function(BaseValidation){


    var rules = [];

    //rules.push({ name: 'country'        ,   display:    'Country'           ,   rules:  'required'});
    //rules.push({ name: 'postalCode'     ,   display:    'Postal code'       ,   rules:  'required'});
    rules.push({ name: 'firstName'      ,   display:    'First name'        ,   rules:  'required|min_length[3]'});
    rules.push({ name: 'lastName'       ,   display:    'Last name'         ,   rules:  'required|min_length[3]'});
    rules.push({ name: 'email'          ,   display:    'Email'             ,   rules:  'required|valid_email'});
    //rules.push({ name: 'username'       ,   display:    'Username'          ,   rules:  'required|min_length[6]'});
    rules.push({ name: 'password'       ,   display:    'Password'          ,   rules:  'required|min_length[6]'});
    //rules.push({ name: 'retypePassword' ,   display:    'Retype password'   ,   rules:  'required|min_length[6]|matches[password]'});

    var validate = new BaseValidation(rules);

    this.run = function(obj){
        return validate.run(obj);
    };

    this.getErrors = function(){
        return validate.getErrors();
    };
};

RegisterValidation.$inject = ['BaseValidation'];
angular.module('signup-registration').service('RegisterValidation',RegisterValidation);
