'user strict'

var servicesModule = angular.module('ccomp.services',['ngResource']);

servicesModule.config(function($httpProvider){
    $httpProvider.responseInterceptors.push('errorHttpInterceptor');
});

servicesModule.factory('LoginResource', function($resource){
    return $resource('login',{},{
        login:{method:'POST', data:{},isArray:false},
        is_logged:{method:'GET'},
        logout:{method:'DELETE'}
    });
});
servicesModule.factory('HomeResource',function($resource){
    return $resource('home',{},{
                getAll:{method:'GET'}
    });
});
servicesModule.factory('ClassroomResource', function($resource){
    return $resource('classroom',{},{
        getAll:{method:'GET'},
        getAvailable:{method:'GET',url:'classroom/available/challenge/:id',params:{id:'@id'}},
        save:{method:'PUT',data:{}}
    });
});
servicesModule.factory('ClassroomCodeResource', function($resource){
    return $resource('classroom_code',{},{});
});
servicesModule.factory('StudentResource', function($resource){
    return $resource('student',{},{
        getStudents:{method:'GET',url:'student/class/:class',params:{class:'@class'}},
        getStudentData:{method:'GET',url:'student/:id',params:{id:'@id'}},
        deleteStudent:{method:'DELETE',url:'student/id/:id/class/:class',params:{id:'@id',class:'@class'}},
        edit:{method:'PUT',data:{}}
    });
});
servicesModule.factory('StudentStatResource',function($resource){
    return $resource('',{},{
        getTopThreeByClass:{method:'GET',url:'stat/top_student_class/class/:class_id',params:{class_id:'@class_id'}},
        getTopBottomByClass:{method:'GET',url:'stat/bottom_student_class/class/:class_id',params:{class_id:'@class_id'}},
        getStudentChallengePlayedTimes:{method:'GET',url:'stat/student_challenge_played_times/class/:class_id',params:{class_id:'@class_id'}},
        getStudentChallengePlayedTimesDetails:{method:'GET',url:'stat/student_challenge_played_times_details/class/:class_id/student/:student_id',params:{class_id:'@class_id',student_id:'@student_id'}},
        getStudentStatDetailChallenge:{method:'GET',url:'stat/student_class_challenge_average/class/:class_id/student/:student_id',params:{class_id:'@class_id',student_id:'@student_id'}}
    });
});
servicesModule.factory('GeoChartResource', function($resource){
    return $resource('stat/geo_chart_challenge',{},{
        getData:{method:'GET',url:'stat/geo_chart_challenge'}
    });
});
servicesModule.factory('AssignedChallengesResource', function($resource){
    return $resource('assigned_challenge',{},{
        getAll:{method:'GET'},
        get:{method:'GET',url:'assigned_challenge/:id',params:{id:'@id'}},
        singleGet:{method:'GET',url:'assigned_challenge/single/:id/class/:class_id',params:{id:'@id',class_id:'@class_id'}},
        delete:{method:'DELETE',url:'assigned_challenge/challclass/:challclass',params:{challclass:'@challclass'}}
    });
});
servicesModule.factory('ContentBuilderResource', function($resource){
    return $resource('content_builder',{},{
        singleGet:{method:'GET',url:'content_builder/single/:id',params:{id:'@id'}}
    });
});
servicesModule.factory('ChallengeResource', function($resource){
    return $resource('challenge',{},{
        get:{method:'GET',url:'challenge/:id',params:{id:'@id'}},
        edit:{method:'PUT',data:{}},
        install:{method:'POST',data:{}}
    });
});
servicesModule.factory('ChallengeStatResource', function($resource){
    return $resource('',{},{
        getTopThreeChallenge:{method:'GET',url:'stat/top_challenge'},
        getChallengePlayedTimes:{method:'GET',url:'stat/challenge_played_times'}
    });
});
servicesModule.factory('QuestionResource', function($resource){
    return $resource('question',{},{
        get:{method:'GET',url:'question/challenge/:id',params:{id:'@id'}},
        delete:{method:'DELETE',url:'question/:id',params:{id:'@id'}},
        getSingle:{method:'GET',url:'question/id/:id',params:{id:'@id'}},
        edit:{method:'PUT'}
    });
});
servicesModule.factory('SubjectResource', function($resource){
    return $resource('subject',{},{
        get:{method:'GET',isArray:true}
    });
});
servicesModule.factory('SkillResource', function($resource){
    return $resource('skill',{},{
        get:{method:'GET',url:'skill/:id',params:{id:'@id'},isArray:true}
    });
});
servicesModule.factory('TopicResource', function($resource){
    return $resource('topic',{},{
        get:{method:'GET',url:'topic/skill/:id',params:{id:'@id'},isArray:true}
    });
});
servicesModule.factory('GradeResource', function($resource){
    return $resource('grade',{},{
        get:{method:'GET',isArray:true}
    });
});
servicesModule.factory('GameResource', function($resource){
    return $resource('game',{},{
        get:{method:'GET',isArray:true}
    });
});
servicesModule.factory('PwdRecoveryResource',function($resource){
    return $resource('forgot_password',{},{})
});
servicesModule.factory('RegistrationResource',function($resource){
    return $resource('registration',{},{});
});
servicesModule.factory('SchoolResource', function($resource){
    return $resource('school',{},{
    });
});
servicesModule.factory('ProfileResource', function($resource){
    return $resource('profile',{},{
        edit:{method:'PUT',data:{}}
    });
});
servicesModule.factory('MarketplaceResource', function($resource){
    return $resource('marketplace',{},{
        get:{method:'GET',url:'marketplace/grade/:id',params:{id:'@id'}},
        install:{method:'POST',data:{}}
    });
});
servicesModule.factory('ImageMakerResource', function($resource, $rootScope){
    return $resource($rootScope.image_maker,{},{})
});
servicesModule.factory('ClassScoreResource', function($resource){
    return $resource('',{},{
        getChallengeScore:{method:'GET',url:'stat/student_class_score/student/:student_id/class/:class_id',params:{student_id:'@student_id',class_id:'@class_id'}},
        getChallengeGlobalScore:{method:'GET',url:'stat/student_challenge_score_global/student/:student_id/class/:class_id',params:{student_id:'@student_id',class_id:'@class_id'}},
        getClassAmountScore:{method:'GET',url:'stat/class_amount_statistic'},
        getTopThreeClass:{method:'GET', url:'stat/top_class'}
    });
});
servicesModule.factory('ChallengeScoreResource', function($resource){
    return $resource('',{},{
        getStudentsScoreChallengesByClass:{method:'GET',url:'stat/student_challenge_score_class/class/:class_id',params:{class_id:'@class_id'}}
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
servicesModule.factory('ModalService', function(){
    var modalType = null;
    var modalTypeService = {};

    modalTypeService.add = function(modal_type){
        modalType = modal_type;
    };

    modalTypeService.get = function(){
        return modalType;
    };

    modalTypeService.remove = function(){
        modalType = null;
    };

    return modalTypeService
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