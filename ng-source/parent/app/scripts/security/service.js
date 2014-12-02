'use strict'

angular.module('security.service',['security.interceptor']);

var Security = function($http, $q, ENV, $cookieStore, ACCESS_LEVEL){

    var service = {};

    var setCurrentUser = function(user){
        if(!user.role || user.role < 0){
            user.role = ACCESS_LEVEL.pub;
        }
        service.currentUser = user;
        $cookieStore.put('ccompparent',service.currentUser)
        $http.defaults.headers.common['X-API-KEY'] = user.token;
    };

    var getCookieData = function(){
        var cData = $cookieStore.get('ccompparent');
        if(angular.isDefined(cData)){
            $http.defaults.headers.common['X-API-KEY'] = cData.token;
        }
        return cData;
    };

    service.currentUser = getCookieData();

    service.login = function(user){
        var request = $http.post(ENV.url + '/login',user);
        var _return_data = {valid:null,intro:null};

        return request.then(function(response){
            var _role = null;
            switch(response.data.intro){
                case 0:
                    _role = ACCESS_LEVEL.registered;
                    break;
                case 1:
                    _role = ACCESS_LEVEL.auth;
                    break;
                default:
                    _role = ACCESS_LEVEL.pub;
                    break;
            }

            setCurrentUser({token:response.data.data,role:_role,email:response.data.email});
            _return_data.valid =  service.isAuthenticated();
            _return_data.intro =  _role;
            return _return_data;
        },function(error){
            return service.isAuthenticated();
        });
    };

    service.loginFacebook = function(user){
        var request = $http.post(ENV.url + '/facebook_login',user);
        return request.then(function(response){
            if(response.data.user === 'new'){
                setCurrentUser({token:response.data.data,role:ACCESS_LEVEL.registered,email:response.data.email});
                return {type:response.data.user, loggedIn:service.isRegistered()};
            }else{
                setCurrentUser({token:response.data.data,role:ACCESS_LEVEL.auth,email:response.data.email});
                return {type:response.data.user, loggedIn:service.isAuthenticated()};
            }
        },function(error){
            return service.isAuthenticated();
        });
    };

    service.loginGoogle = function(user){
        var request = $http.post(ENV.url + '/google_login',user);
        return request.then(function(response){
            if(response.data.user === 'new'){
                setCurrentUser({token:response.data.data,role:ACCESS_LEVEL.registered,email:response.data.email});
                return {type:response.data.user, loggedIn:service.isRegistered()};
            }else{
                setCurrentUser({token:response.data.data,role:ACCESS_LEVEL.auth,email:response.data.email});
                return {type:response.data.user, loggedIn:service.isAuthenticated()};
            }
        },function(error){
            return service.isAuthenticated();
        });
    };

    service.register = function(user){
        var request = $http.post(ENV.url + '/registration', user);
        return request.then(function(response){
            setCurrentUser({token:response.data.data,role:ACCESS_LEVEL.registered,email:response.data.email});
            return service.isRegistered();
        },function(error){
            return service.isRegistered();
        });
    };

    service.logout = function(){
        service.currentUser = null;
        setCurrentUser({role:ACCESS_LEVEL.pub, token:null});
    };

    service.requestCurrentUser = function(){
        if(service.isAuthenticated()){
            return $q.when(service.currentUser);
        }else{
            setCurrentUser({role:ACCESS_LEVEL.pub});
            return $http.get(ENV.url + '/current-user').then(function(response){});
        }
    };

    service.isAuthenticated = function(){
        if(angular.isUndefined(service.currentUser) || service.currentUser === null)return false;
        switch (service.currentUser.role){
            case ACCESS_LEVEL.auth:
                return true;
            default :
                return false;
        }
    };

    service.isRegistered = function(){
        if(angular.isUndefined(service.currentUser) || service.currentUser === null)return false;
        switch (service.currentUser.role){
            case ACCESS_LEVEL.registered:
                return true;
            default :
                return false;
        }
    };

    service.setRole = function(role){
        service.currentUser.role = role;
        setCurrentUser(service.currentUser);
    };

    service.getEmail = function(){
       return service.currentUser.email;
    };

    return service;
};


Security.$inject = ['$http','$q','ENV','$cookieStore','ACCESS_LEVEL'];
angular.module('security.service').factory('Security', Security);