'user strict'

var servicesModule = angular.module('parent-app.services',['ngResource']);
servicesModule.factory('LoginResource', function($resource){
    return $resource('login',{},{
        is_logged:{method:'GET'},
        login:{method:'POST', data:{},isArray:false}
    });
});
servicesModule.factory('RegistrationResource', function($resource){
    return $resource('registration',{},{});
});
servicesModule.factory('ForgotPassword', function($resource){
    return $resource('password_recovery',{},{});
});
servicesModule.factory('RegistrationFacebookResource', function($resource){
    return $resource('registration_facebook',{},{});
});
servicesModule.factory('RegistrationGoogleResource', function($resource){
    return $resource('registration_google',{},{})
});
servicesModule.factory('SocialLoginResource', function($resource){
    return $resource('login_social',{},{
        login:{method:'POST', data:{},isArray:false}
    });
});
servicesModule.factory('ChildResource', function($resource){
    return $resource('student',{},{});
});
servicesModule.factory('TimezoneResource', function($resource){
    return $resource('timezone',{},{
        get:{method:'GET',isArray:true}
    });
});
servicesModule.factory('DemoResource', function($resource){
    return $resource('demo',{},{});
});
servicesModule.factory('ClassResource', function($resource){
    return $resource('class_student',{},{
        getClasses:{method:'GET',url:'class_student/student/:id',params:{id:'@id'}}
    })
});
servicesModule.factory('ChildStatResource', function($resource){
    return $resource('',{},{
        getChallengeGlobalScore:{method:'GET',url:'stat/student_challenge_score_global/student/:student_id/class/:class_id',params:{student_id:'@student_id',class_id:'@class_id'}},
        getChallengeScore:{method:'GET',url:'stat/student_class_score/student/:student_id/class/:class_id',params:{student_id:'@student_id',class_id:'@class_id'}}
    })
});
servicesModule.factory('ProfileResource', function($resource){
    return $resource('profile',{},{
        save:{method:'PUT',url:'profile',data:{}}
    });
});
servicesModule.factory('SocialConnectionResource',function($resource){
    return $resource('social_network_connections',{},{
        getSocialNetworks:{method:'GET',url:'social_network_connections'},
        deleteNetwork:{method:'DELETE',url:'social_network_connections/network/:network_type',params:{network_type:'@network_type'}}
    });
});
servicesModule.factory('ErrorService', function(){
    return {
        errorMessage: null,
        setError: function(msg){
            this.errorMessage = msg;
        },
        clearError: function(){
            this.errorMessage = null;
        }
    };
});
servicesModule.factory('errorHttpInterceptor',
    function($q, $location, ErrorService, $rootScope){
        return function(promise){
            return promise.then(function(response){
                    ErrorService.clearError();
                    return response;
                },
                function (response){
                    if(response.status === 401){
                        ErrorService.setError(response.data.error);
                        $rootScope.$broadcast('event:loginRequired');
                    }else if(response.status >= 402 && response.status < 500){
                        ErrorService.setError("Server was unable to find what you were looking for...");
                    }else if(response.status === 400){
                        if(response.data.redirect !== angular.undefined){
                            $location.path('/login_error');
                        }
                        ErrorService.setError(response.data);
                    }
                    return $q.reject(response);
                })
        }
    });
servicesModule.config(function($httpProvider){
    $httpProvider.responseInterceptors.push('errorHttpInterceptor');
});