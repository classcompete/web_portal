'use strict';

var SetupStudentValidation = function(BaseValidation, $q, $http, ENV){


    var rules = [];

    rules.push({ name: 'firstName'      ,   display:    'First name'        ,   rules:  'required|min_length[3]'});
    rules.push({ name: 'lastName'       ,   display:    'Last name'         ,   rules:  'required|min_length[3]'});
    //rules.push({ name: 'email'          ,   display:    'Email'             ,   rules:  'required|valid_email'});
    rules.push({ name: 'username'       ,   display:    'Username'          ,   rules:  'required|min_length[6]'});
    rules.push({ name: 'password'       ,   display:    'Password'          ,   rules:  'required|min_length[6]'});
    rules.push({ name: 'retypePassword' ,   display:    'Retype password'   ,   rules:  'required|min_length[6]|matches[password]'});
    rules.push({ name: 'grade'          ,   display:    'Grade'             ,   rules:  'required'});
    rules.push({ name: 'gender'         ,   display:    'Gender'            ,   rules:  'required'});
    //rules.push({ name: 'birthday'       ,   display:    'Birthday'          ,   rules:  'required'});

    var validate = new BaseValidation(rules);

    this.run = function(obj){
        return validate.run(obj);
    };

    this.getErrors = function(){
        return validate.getErrors();
    };

};

SetupStudentValidation.$inject = ['BaseValidation','$q','$http','ENV'];
angular.module('setupstudent').service('SetupStudentValidation',SetupStudentValidation);
