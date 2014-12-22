'use strict';

var StudentValidation = function(BaseValidation, $http, ENV, $q){


    var rules = [];

    rules.push({ name: 'firstName'      ,   display:    'First name'        ,   rules:  'required|min_length[3]'});
    rules.push({ name: 'lastName'       ,   display:    'Last name'         ,   rules:  'required|min_length[3]'});
    //rules.push({ name: 'email'          ,   display:    'Email'             ,   rules:  'required|valid_email'});
    rules.push({ name: 'username'       ,   display:    'Username'          ,   rules:  'required|min_length[6]'});
    rules.push({ name: 'grade'          ,   display:    'Grade'             ,   rules:  'required'});

    rules.push({ name: 'birthday'       ,   display:    'Birthday'          ,   rules:  'required|valid_date'});


    var validate = null;

    this.run = function(obj){

        if(angular.isDefined(obj.password) || angular.isDefined(obj.retypePassword)){
            rules.push({ name: 'password'       ,   display:    'Password'          ,   rules:  'required|min_length[6]'});
            rules.push({ name: 'retypePassword' ,   display:    'Retype password'   ,   rules:  'required|min_length[6]|matches[password]'});
        }else{

            for(var i = 0; i < rules.length; i++){
                if(rules[i].name === 'password'){
                    rules.splice(i,1)
                }
                if(rules[i].name === 'retypePassword'){
                    rules.splice(i,1)
                }
            }
        }

        validate = new BaseValidation(rules);
        return validate.run(obj);
    };

    this.getErrors = function(){
        return validate.getErrors();
    };

    BaseValidation.prototype._hooks.valid_date = function(field){
        var d = new Date(field.value);
        return isNaN(d.getTime()) ? false:true;
    };

};

StudentValidation.$inject = ['BaseValidation','$http','ENV','$q'];
angular.module('students').service('StudentValidation',StudentValidation);
