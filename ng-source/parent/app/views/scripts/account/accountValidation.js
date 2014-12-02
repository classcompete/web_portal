'use strict';

var AccountValidation = function(BaseValidation){


    var rules = [];
    var validate = null;
//    rules.push({ name: 'country'        ,   display:    'Country'           ,   rules:  'required'});
//    rules.push({ name: 'postalCode'     ,   display:    'Postal code'       ,   rules:  'required'});
    rules.push({ name: 'firstName'      ,   display:    'First name'        ,   rules:  'required|min_length[3]'});
    rules.push({ name: 'lastName'       ,   display:    'Last name'         ,   rules:  'required|min_length[3]'});
    rules.push({ name: 'email'          ,   display:    'Email'             ,   rules:  'required|valid_email'});
    rules.push({ name: 'username'       ,   display:    'Username'          ,   rules:  'required|min_length[6]'});


    this.run = function(obj){
        if(angular.isDefined(obj.password) || angular.isDefined(obj.retypePassword)){
            rules.push({ name: 'password'       ,   display:    'Password'          ,   rules:  'required|min_length[6]'});
            rules.push({ name: 'retypePassword' ,   display:    'Retype password'   ,   rules:  'required|matches[password]|min_length[6]'});
            if(angular.isUndefined(obj.password))obj.password = '';
            if(angular.isUndefined(obj.retypePassword))obj.retypePassword = '';
        }

        validate = new BaseValidation(rules);
        return validate.run(obj);
    };

    this.getErrors = function(){
        return validate.getErrors();
    };
};

AccountValidation.$inject = ['BaseValidation'];
angular.module('account').service('AccountValidation',AccountValidation);
